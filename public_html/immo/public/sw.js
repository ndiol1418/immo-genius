// ═══════════════════════════════════════════════════════
// Teranga Immobilier — Service Worker v3
// Strategies: Cache-First (assets), Network-First (pages),
//             Stale-While-Revalidate (annonces)
// ═══════════════════════════════════════════════════════

const CACHE_STATIC  = 'teranga-static-v3';
const CACHE_PAGES   = 'teranga-pages-v3';
const CACHE_ANNONCES = 'teranga-annonces-v3';
const OFFLINE_URL   = '/offline';

const STATIC_ASSETS = [
  '/assets/biblio/bootstrap/css/bootstrap.min.css',
  '/assets/biblio/bootstrap-icons/bootstrap-icons.css',
  '/assets/css/main.css',
  '/assets/css/style.css',
  '/assets/biblio/bootstrap/js/bootstrap.bundle.min.js',
  '/img/logo-teranga.png',
];

const PRECACHE_PAGES = [
  '/',
  '/louer',
  '/acheter',
  '/blog',
  '/estimation',
  '/offline',
];

// ─── IndexedDB helpers ────────────────────────────────
const DB_NAME    = 'teranga-offline';
const DB_VERSION = 1;
const STORE_NAME = 'annonces-recent';

function openDB() {
  return new Promise((resolve, reject) => {
    const req = indexedDB.open(DB_NAME, DB_VERSION);
    req.onupgradeneeded = e => {
      const db = e.target.result;
      if (!db.objectStoreNames.contains(STORE_NAME)) {
        const store = db.createObjectStore(STORE_NAME, { keyPath: 'url' });
        store.createIndex('visitedAt', 'visitedAt');
      }
    };
    req.onsuccess = e => resolve(e.target.result);
    req.onerror   = e => reject(e.target.error);
  });
}

async function saveAnnonceToIDB(url, data) {
  try {
    const db = await openDB();
    const tx = db.transaction(STORE_NAME, 'readwrite');
    const store = tx.objectStore(STORE_NAME);
    store.put({ url, ...data, visitedAt: Date.now() });
    // Keep only last 10
    const all = await new Promise(r => { const req = store.getAll(); req.onsuccess = e => r(e.target.result); });
    if (all.length > 10) {
      all.sort((a, b) => a.visitedAt - b.visitedAt);
      for (let i = 0; i < all.length - 10; i++) store.delete(all[i].url);
    }
    await new Promise(r => { tx.oncomplete = r; });
  } catch(e) { /* silently fail */ }
}

async function getRecentAnnonces() {
  try {
    const db = await openDB();
    const tx = db.transaction(STORE_NAME, 'readonly');
    const store = tx.objectStore(STORE_NAME);
    return new Promise(r => {
      const req = store.getAll();
      req.onsuccess = e => r(e.target.result.sort((a,b) => b.visitedAt - a.visitedAt));
    });
  } catch(e) { return []; }
}

// ─── Install ──────────────────────────────────────────
self.addEventListener('install', event => {
  event.waitUntil(
    Promise.all([
      caches.open(CACHE_STATIC).then(c => c.addAll(STATIC_ASSETS).catch(() => {})),
      caches.open(CACHE_PAGES).then(c => c.addAll(PRECACHE_PAGES).catch(() => {})),
    ])
  );
  self.skipWaiting();
});

// ─── Activate ─────────────────────────────────────────
self.addEventListener('activate', event => {
  const valid = [CACHE_STATIC, CACHE_PAGES, CACHE_ANNONCES];
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.filter(k => !valid.includes(k)).map(k => caches.delete(k)))
    )
  );
  self.clients.claim();
});

// ─── Fetch ────────────────────────────────────────────
self.addEventListener('fetch', event => {
  if (event.request.method !== 'GET') return;
  const url = new URL(event.request.url);
  if (url.origin !== self.location.origin) return;
  if (url.pathname.startsWith('/api/') || url.pathname.startsWith('/admin/')) return;

  // Cache-First: static assets (CSS, JS, images, fonts)
  if (/\.(css|js|png|jpg|jpeg|gif|svg|woff2?|ttf|ico)(\?.*)?$/.test(url.pathname)) {
    event.respondWith(
      caches.match(event.request).then(cached => {
        if (cached) return cached;
        return fetch(event.request).then(response => {
          if (response.ok) {
            const clone = response.clone();
            caches.open(CACHE_STATIC).then(c => c.put(event.request, clone));
          }
          return response;
        }).catch(() => new Response('', { status: 503 }));
      })
    );
    return;
  }

  // Stale-While-Revalidate: annonces pages
  if (url.pathname.startsWith('/annonces/') || url.pathname.startsWith('/blog/')) {
    event.respondWith(
      caches.open(CACHE_ANNONCES).then(cache => {
        return cache.match(event.request).then(cached => {
          const fetchPromise = fetch(event.request).then(response => {
            if (response.ok) cache.put(event.request, response.clone());
            return response;
          }).catch(() => cached || offlineFallback(event));
          return cached || fetchPromise;
        });
      })
    );
    return;
  }

  // Network-First: all other pages
  event.respondWith(
    fetch(event.request).then(response => {
      if (response.ok) {
        const clone = response.clone();
        caches.open(CACHE_PAGES).then(c => c.put(event.request, clone));
      }
      return response;
    }).catch(() => {
      return caches.match(event.request).then(cached => {
        return cached || offlineFallback(event);
      });
    })
  );
});

function offlineFallback(event) {
  if (event.request.mode === 'navigate') {
    return caches.match(OFFLINE_URL).then(r => r || new Response('<h1>Hors ligne</h1>', { headers: { 'Content-Type': 'text/html' } }));
  }
  return new Response('', { status: 503 });
}

// ─── Push Notifications ───────────────────────────────
self.addEventListener('push', event => {
  let data = { title: 'Teranga Immobilier', body: 'Nouveau bien disponible !', url: '/' };
  try { data = event.data ? { ...data, ...event.data.json() } : data; } catch(e) {}

  event.waitUntil(
    self.registration.showNotification(data.title, {
      body:    data.body,
      icon:    '/img/logo-teranga.png',
      badge:   '/img/logo-teranga.png',
      vibrate: [200, 100, 200],
      data:    { url: data.url },
      actions: [
        { action: 'view',    title: 'Voir l\'annonce' },
        { action: 'dismiss', title: 'Ignorer' }
      ]
    })
  );
});

self.addEventListener('notificationclick', event => {
  event.notification.close();
  if (event.action === 'dismiss') return;
  const url = event.notification.data?.url || '/';
  event.waitUntil(
    clients.matchAll({ type: 'window' }).then(list => {
      const existing = list.find(c => c.url === url && 'focus' in c);
      if (existing) return existing.focus();
      return clients.openWindow(url);
    })
  );
});

// ─── Message from page (save annonce to IDB) ─────────
self.addEventListener('message', event => {
  if (event.data?.type === 'CACHE_ANNONCE') {
    saveAnnonceToIDB(event.data.url, event.data.annonce);
  }
});
