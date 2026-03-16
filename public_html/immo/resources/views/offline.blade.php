<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hors ligne — Teranga Immobilier</title>
  <meta name="theme-color" content="#2E7D32">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: 'Segoe UI', sans-serif; background:#f8f9fa; color:#333; min-height:100vh; display:flex; flex-direction:column; }
    .top-bar { background:#2E7D32; color:#fff; text-align:center; padding:12px; font-size:13px; font-weight:600; }
    .container { max-width:640px; margin:0 auto; padding:40px 20px; flex:1; }
    .hero { text-align:center; margin-bottom:40px; }
    .hero-icon { font-size:72px; margin-bottom:16px; }
    h1 { font-size:24px; color:#0d1c2e; margin-bottom:8px; }
    p { color:#666; font-size:14px; line-height:1.7; margin-bottom:20px; }
    .btn { display:inline-block; background:#2E7D32; color:#fff; padding:12px 28px; border-radius:10px; text-decoration:none; font-weight:600; font-size:14px; border:none; cursor:pointer; }
    .btn-outline { background:#fff; color:#2E7D32; border:2px solid #2E7D32; margin-left:10px; }
    .annonces-section h2 { font-size:16px; font-weight:700; margin-bottom:16px; color:#0d1c2e; border-bottom:2px solid #e9ecef; padding-bottom:8px; }
    .annonce-card { background:#fff; border-radius:12px; padding:16px; margin-bottom:12px; box-shadow:0 2px 8px rgba(0,0,0,.06); display:flex; gap:16px; align-items:center; }
    .annonce-thumb { width:64px; height:64px; border-radius:8px; background:#e9ecef; flex-shrink:0; overflow:hidden; }
    .annonce-thumb img { width:100%; height:100%; object-fit:cover; }
    .annonce-info { flex:1; }
    .annonce-title { font-size:13px; font-weight:600; margin-bottom:4px; }
    .annonce-price { font-size:14px; color:#2E7D32; font-weight:700; }
    .annonce-meta { font-size:11px; color:#aaa; margin-top:2px; }
    #no-annonces { color:#aaa; font-size:13px; text-align:center; padding:20px; }
    .connection-badge { display:inline-block; padding:3px 12px; border-radius:20px; font-size:11px; font-weight:700; }
  </style>
</head>
<body>

<div class="top-bar">
  📡 Vous êtes hors ligne — Mode consultation
</div>

<div class="container">

  <div class="hero">
    <div class="hero-icon">📵</div>
    <h1>Vous êtes hors ligne</h1>
    <p>Pas de connexion internet détectée. Voici vos dernières annonces consultées, disponibles hors ligne.</p>
    <button class="btn" onclick="window.location.reload()">🔄 Réessayer</button>
    <a href="/" class="btn btn-outline">🏠 Accueil</a>
  </div>

  <div class="annonces-section">
    <h2>📋 Dernières annonces consultées</h2>
    <div id="annonces-list">
      <div id="no-annonces" style="display:none;">Aucune annonce en cache. Naviguez sur le site pour en sauvegarder.</div>
    </div>
  </div>

</div>

<script>
// Load recent annonces from IndexedDB
const DB_NAME = 'teranga-offline';
const STORE_NAME = 'annonces-recent';

function openDB() {
  return new Promise((resolve, reject) => {
    const req = indexedDB.open(DB_NAME, 1);
    req.onsuccess = e => resolve(e.target.result);
    req.onerror   = e => reject(e.target.error);
    req.onupgradeneeded = e => {
      const db = e.target.result;
      if (!db.objectStoreNames.contains(STORE_NAME)) {
        db.createObjectStore(STORE_NAME, { keyPath: 'url' });
      }
    };
  });
}

async function loadAnnonces() {
  try {
    const db = await openDB();
    const tx = db.transaction(STORE_NAME, 'readonly');
    const store = tx.objectStore(STORE_NAME);
    const all = await new Promise((r, j) => {
      const req = store.getAll();
      req.onsuccess = e => r(e.target.result);
      req.onerror   = e => j(e);
    });
    all.sort((a, b) => b.visitedAt - a.visitedAt);
    renderAnnonces(all);
  } catch(e) {
    document.getElementById('no-annonces').style.display = 'block';
  }
}

function renderAnnonces(annonces) {
  const list = document.getElementById('annonces-list');
  const noMsg = document.getElementById('no-annonces');
  if (!annonces.length) { noMsg.style.display = 'block'; return; }
  annonces.forEach(a => {
    const card = document.createElement('a');
    card.href = a.url;
    card.style.textDecoration = 'none';
    card.innerHTML = `
      <div class="annonce-card">
        <div class="annonce-thumb">
          ${a.image ? `<img src="${a.image}" alt="${a.titre||''}">` : '<div style="height:100%;display:flex;align-items:center;justify-content:center;font-size:24px;">🏠</div>'}
        </div>
        <div class="annonce-info">
          <div class="annonce-title">${a.titre || 'Annonce'}</div>
          <div class="annonce-price">${a.prix ? Number(a.prix).toLocaleString('fr') + ' CFA' : ''}</div>
          <div class="annonce-meta">${a.commune || ''} · Consulté ${timeAgo(a.visitedAt)}</div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="#ccc" d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
      </div>`;
    list.appendChild(card);
  });
}

function timeAgo(ts) {
  const diff = Date.now() - ts;
  const m = Math.floor(diff / 60000);
  if (m < 1)  return 'à l\'instant';
  if (m < 60) return `il y a ${m} min`;
  const h = Math.floor(m / 60);
  if (h < 24) return `il y a ${h}h`;
  return `il y a ${Math.floor(h/24)}j`;
}

loadAnnonces();
</script>
</body>
</html>
