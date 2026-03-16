@extends('layouts.accueil')
@section('title', 'Notifications — ' . config('app.name'))

@section('content')
<section class="section" style="padding-top:120px;min-height:80vh;">
<div class="container" style="max-width:580px;">

  <div class="text-center mb-5">
    <div style="font-size:64px;margin-bottom:16px;">🔔</div>
    <h3 class="fw-bold">Activez les notifications</h3>
    <p class="text-muted" style="font-size:14px;line-height:1.7;">
      Recevez des alertes instantanées quand un bien correspond à vos critères,
      ou quand une annonce est mise en avant.
    </p>
  </div>

  @if(session('success'))
    <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
  @endif

  <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px;">
    <div id="push-status" class="text-center mb-4" style="display:none;"></div>

    <div class="d-flex flex-column gap-3">
      <button id="btn-subscribe" class="btn btn-lg fw-bold"
              style="background:#2E7D32;color:#fff;border-radius:12px;font-size:15px;" onclick="subscribePush()">
        🔔 Activer les notifications
      </button>
      <button id="btn-unsubscribe" class="btn btn-lg" style="background:#f8f9fa;color:#666;border-radius:12px;display:none;" onclick="unsubscribePush()">
        🔕 Désactiver les notifications
      </button>
    </div>

    <div class="mt-4 pt-3" style="border-top:1px solid #f0f0f0;">
      <div style="font-size:12px;color:#aaa;font-weight:600;margin-bottom:10px;">CE QUE VOUS RECEVREZ</div>
      <div class="d-flex flex-column gap-2">
        @foreach(['Nouvelles annonces correspondant à vos alertes', 'Baisses de prix sur vos favoris', 'Nouvelles annonces vedette dans votre zone', 'Actualités du marché immobilier'] as $item)
        <div style="font-size:13px;color:#555;display:flex;align-items:center;gap:8px;">
          <span style="color:#2E7D32;font-weight:700;">✓</span> {{ $item }}
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <p class="text-center text-muted" style="font-size:12px;">
    Vous pouvez désactiver les notifications à tout moment depuis les paramètres de votre navigateur.
  </p>

</div>
</section>
@endsection

@section('scriptBottom')
<script>
const PUSH_SUBSCRIBE_URL   = '{{ route("push.subscribe") }}';
const PUSH_UNSUBSCRIBE_URL = '{{ route("push.unsubscribe") }}';
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

// Check current state
async function checkState() {
  if (!('Notification' in window) || !('serviceWorker' in navigator)) {
    showStatus('warning', '⚠️ Votre navigateur ne supporte pas les notifications push.');
    document.getElementById('btn-subscribe').style.display = 'none';
    return;
  }

  const reg = await navigator.serviceWorker.ready;
  const sub = await reg.pushManager.getSubscription();

  if (Notification.permission === 'denied') {
    showStatus('danger', '🚫 Notifications bloquées. Autorisez-les dans les paramètres du navigateur.');
    document.getElementById('btn-subscribe').style.display = 'none';
  } else if (sub) {
    showStatus('success', '✅ Notifications activées !');
    document.getElementById('btn-subscribe').style.display = 'none';
    document.getElementById('btn-unsubscribe').style.display = 'block';
  } else {
    showStatus('info', '💡 Cliquez pour activer les notifications.');
  }
}

function showStatus(type, msg) {
  const el = document.getElementById('push-status');
  const colors = { success:'#d1fae5', danger:'#fee2e2', warning:'#fef3c7', info:'#e0f2fe' };
  el.style.cssText = `display:block;background:${colors[type]||'#f0f0f0'};border-radius:10px;padding:12px 16px;font-size:13px;`;
  el.textContent = msg;
}

async function subscribePush() {
  try {
    const permission = await Notification.requestPermission();
    if (permission !== 'granted') {
      showStatus('danger', '🚫 Permission refusée. Activez les notifications dans les paramètres.');
      return;
    }

    const reg = await navigator.serviceWorker.ready;
    const sub = await reg.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: urlBase64ToUint8Array('{{ config("services.vapid.public_key", "BEl62iUYgUivxIkv69yViEuiBIa-Ib9-SkvMeAtA3LFgDzkrxZJjSgSnfckjBJuBkr3qBUYIHBQFLXYp5Nksh8U") }}')
    });

    const json = sub.toJSON();
    await fetch(PUSH_SUBSCRIBE_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
      body: JSON.stringify({ endpoint: json.endpoint, p256dh: json.keys.p256dh, auth: json.keys.auth })
    });

    showStatus('success', '✅ Notifications activées avec succès !');
    document.getElementById('btn-subscribe').style.display = 'none';
    document.getElementById('btn-unsubscribe').style.display = 'block';
  } catch(e) {
    showStatus('danger', '❌ Impossible d\'activer les notifications. Réessayez.');
  }
}

async function unsubscribePush() {
  try {
    const reg = await navigator.serviceWorker.ready;
    const sub = await reg.pushManager.getSubscription();
    if (sub) {
      await fetch(PUSH_UNSUBSCRIBE_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ endpoint: sub.endpoint })
      });
      await sub.unsubscribe();
    }
    showStatus('info', '🔕 Notifications désactivées.');
    document.getElementById('btn-subscribe').style.display = 'block';
    document.getElementById('btn-unsubscribe').style.display = 'none';
  } catch(e) {
    showStatus('danger', '❌ Erreur lors de la désactivation.');
  }
}

function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64  = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
  const rawData = window.atob(base64);
  return Uint8Array.from([...rawData].map(c => c.charCodeAt(0)));
}

checkState();
</script>
@endsection
