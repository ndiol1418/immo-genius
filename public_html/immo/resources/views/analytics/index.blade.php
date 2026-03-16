@extends('layouts.accueil')

@section('title', 'Analytics — ' . config('app.name'))

@section('content')
<section class="section mt-4" style="min-height:80vh;">
<div class="container" style="margin-top:100px;">

  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h4 class="mb-0">
      <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M16 11.78L20.24 4.45L21.97 5.45L16.74 14.5L10.23 10.75L5.46 19H22V21H2V3H4V17.54L9.5 8L16 11.78Z"/></svg>
      Dashboard Analytics
    </h4>
    <div class="d-flex gap-2">
      <a href="{{ route('agent.profil.edit') }}" class="btn btn-sm" style="background:#0d1c2e;color:#fff;border-radius:8px;font-size:12px;">✏️ Mon profil</a>
      <span class="text-muted" style="font-size:13px;align-self:center;">Agent : <strong>{{ $agent->nom_complet }}</strong></span>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
  @endif

  {{-- ═══════════════════════════════════════
       🚀 BOOSTER MES ANNONCES
       ═══════════════════════════════════════ --}}
  @php
    $mesAnnonces = \App\Models\Annonce::withoutGlobalScope(\App\Scopes\AnnonceScope::class)
        ->where('fournisseur_id', $agent->id)
        ->with(['boostsActifs' => fn($q) => $q->actif()])
        ->latest()->get();
    $tarifs = \App\Models\BoostAnnonce::tarifs();
  @endphp
  <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px;">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
      <h6 class="fw-bold mb-0">🚀 Booster mes annonces</h6>
      <button onclick="document.getElementById('modal-paiement').style.display='flex'" class="btn btn-sm fw-bold"
              style="background:#0d1c2e;color:#fff;border-radius:8px;font-size:11px;">
        📱 Payer par Mobile Money
      </button>
    </div>
    <p class="text-muted mb-3" style="font-size:13px;">Augmentez la visibilité de vos annonces en les boostant en haut des résultats.</p>

    {{-- Modal paiement Mobile Money --}}
    <div id="modal-paiement" style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,.6);align-items:center;justify-content:center;" onclick="if(event.target===this)this.style.display='none'">
      <div style="background:#fff;border-radius:20px;padding:28px;max-width:400px;width:90%;position:relative;">
        <button onclick="document.getElementById('modal-paiement').style.display='none'" style="position:absolute;top:12px;right:16px;background:none;border:none;font-size:22px;cursor:pointer;color:#888;">×</button>
        <h6 class="fw-bold mb-4 text-center">📱 Paiement Mobile Money</h6>
        <p class="text-muted text-center mb-4" style="font-size:13px;">Choisissez votre opérateur et envoyez le montant correspondant à votre boost</p>

        {{-- Wave --}}
        <div style="background:#f0f7ff;border-radius:14px;padding:16px 20px;margin-bottom:12px;border-left:4px solid #1877F2;">
          <div class="d-flex align-items-center gap-3 mb-2">
            <div style="width:40px;height:40px;background:#1877F2;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">🌊</div>
            <div>
              <div style="font-size:14px;font-weight:700;color:#1877F2;">Wave</div>
              <div style="font-size:12px;color:#666;">Envoi instantané</div>
            </div>
          </div>
          <div style="background:#fff;border-radius:10px;padding:12px;text-align:center;">
            <div style="font-size:11px;color:#888;margin-bottom:4px;">NUMÉRO WAVE</div>
            <div style="font-size:22px;font-weight:800;color:#1877F2;letter-spacing:2px;" onclick="copyNumber(this)">+221 77 000 00 00</div>
            <div style="font-size:11px;color:#aaa;margin-top:4px;">Cliquez pour copier</div>
          </div>
          <div style="font-size:11px;color:#666;margin-top:10px;padding:8px;background:#e8f0fe;border-radius:8px;">
            💡 Objet du paiement : votre email + type de boost (Standard/Premium/Vedette)
          </div>
        </div>

        {{-- Orange Money --}}
        <div style="background:#fff8f0;border-radius:14px;padding:16px 20px;margin-bottom:20px;border-left:4px solid #FF6600;">
          <div class="d-flex align-items-center gap-3 mb-2">
            <div style="width:40px;height:40px;background:#FF6600;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">🟠</div>
            <div>
              <div style="font-size:14px;font-weight:700;color:#FF6600;">Orange Money</div>
              <div style="font-size:12px;color:#666;">Disponible 24h/24</div>
            </div>
          </div>
          <div style="background:#fff;border-radius:10px;padding:12px;text-align:center;">
            <div style="font-size:11px;color:#888;margin-bottom:4px;">NUMÉRO ORANGE MONEY</div>
            <div style="font-size:22px;font-weight:800;color:#FF6600;letter-spacing:2px;" onclick="copyNumber(this)">+221 77 000 00 01</div>
            <div style="font-size:11px;color:#aaa;margin-top:4px;">Cliquez pour copier</div>
          </div>
        </div>

        <div style="background:#f8f9fa;border-radius:12px;padding:14px;font-size:12px;color:#555;text-align:center;">
          Après paiement, envoyez une capture à notre admin via WhatsApp au
          <strong>+221 77 000 00 02</strong> avec votre annonce.<br>
          <span style="color:#2E7D32;font-weight:600;">Activation sous 2h maximum.</span>
        </div>
      </div>
    </div>

    @if($mesAnnonces->isEmpty())
      <p class="text-muted" style="font-size:13px;">Vous n'avez pas encore d'annonces.</p>
    @else
    <div class="table-responsive">
      <table class="table table-sm align-middle" style="font-size:12px;">
        <thead>
          <tr style="background:#f8f9fa;">
            <th>Annonce</th>
            <th>Prix</th>
            <th>Boost actuel</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($mesAnnonces as $ann)
          @php
            $boostActif = \App\Models\BoostAnnonce::where('annonce_id', $ann->id)->actif()->first();
          @endphp
          <tr>
            <td>
              <a href="{{ route('annonce', $ann->slug) }}" class="text-decoration-none text-dark" target="_blank">
                {{ \Str::limit($ann->name ?? 'Annonce #'.$ann->id, 30) }}
              </a>
            </td>
            <td>{{ number_format($ann->prix, 0, ',', ' ') }} CFA</td>
            <td>
              @if($boostActif)
                @php $t = $tarifs[$boostActif->type]; @endphp
                <span class="badge px-2 py-1" style="background:{{ $boostActif->type==='vedette'?'#dc3545':($boostActif->type==='premium'?'#C49A0C':'#2E7D32') }};font-size:10px;">
                  {{ $t['emoji'] }} {{ $t['label'] }} — expire {{ $boostActif->date_fin->format('d/m') }}
                </span>
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td class="text-center">
              <div class="d-flex gap-1 justify-content-center flex-wrap">
                @foreach($tarifs as $key => $t)
                <form method="POST" action="{{ route('boost.store') }}" style="display:inline;">
                  @csrf
                  <input type="hidden" name="annonce_id" value="{{ $ann->id }}">
                  <input type="hidden" name="type" value="{{ $key }}">
                  <button type="submit" title="{{ $t['label'] }} — {{ $t['duree'] }}j — {{ number_format($t['prix'],0,',','.') }} CFA"
                    style="background:{{ $key==='vedette'?'#dc3545':($key==='premium'?'#C49A0C':'#2E7D32') }};color:#fff;border:none;border-radius:6px;padding:3px 8px;font-size:10px;cursor:pointer;"
                    onclick="return confirm('Activer boost {{ $t['label'] }} ({{ $t['prix'] }} CFA / {{ $t['duree'] }} jours) ?')">
                    {{ $t['emoji'] }} {{ $t['label'] }}
                  </button>
                </form>
                @endforeach
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Légende tarifs --}}
    <div class="d-flex flex-wrap gap-3 mt-2">
      @foreach($tarifs as $key => $t)
      <div style="font-size:11px;color:#666;">
        <span style="color:{{ $key==='vedette'?'#dc3545':($key==='premium'?'#C49A0C':'#2E7D32') }};font-weight:700;">{{ $t['emoji'] }} {{ $t['label'] }}</span>
        — {{ $t['duree'] }} jours — <strong>{{ number_format($t['prix'],0,',','.') }} CFA</strong>
      </div>
      @endforeach
    </div>
    @endif
  </div>

  {{-- KPI Cards --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 text-center h-100">
        <div style="font-size:11px;color:#888;margin-bottom:6px;">VUES TOTALES</div>
        <div style="font-size:28px;font-weight:700;color:#0d1c2e;">{{ number_format($totalVues) }}</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 text-center h-100">
        <div style="font-size:11px;color:#888;margin-bottom:6px;">CONTACTS REÇUS</div>
        <div style="font-size:28px;font-weight:700;color:#2E7D32;">{{ number_format($totalContacts) }}</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 text-center h-100">
        <div style="font-size:11px;color:#888;margin-bottom:6px;">TAUX CONVERSION</div>
        <div style="font-size:28px;font-weight:700;color:#f59e0b;">{{ $tauxConv }}%</div>
        <div style="font-size:10px;color:#aaa;">vues → contacts</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 text-center h-100">
        <div style="font-size:11px;color:#888;margin-bottom:6px;">ANNONCES ACTIVES</div>
        <div style="font-size:28px;font-weight:700;color:#6366f1;">{{ $vuesParAnnonce->count() }}</div>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    {{-- Graphique barres : vues par annonce --}}
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm p-4 h-100">
        <h6 class="mb-3">Vues par annonce (top 10)</h6>
        <canvas id="chartBarres" height="220"></canvas>
      </div>
    </div>

    {{-- Graphique ligne : évolution 30 jours --}}
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm p-4 h-100">
        <h6 class="mb-3">Évolution des vues — 30 derniers jours</h6>
        <canvas id="chartLigne" height="220"></canvas>
      </div>
    </div>
  </div>

  {{-- Top 5 --}}
  <div class="row g-4 mb-4">
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm p-4">
        <h6 class="mb-3">🏆 Top 5 annonces les plus vues</h6>
        @forelse($top5 as $idx => $vue)
          <div class="d-flex align-items-center justify-content-between py-2" style="border-bottom:1px solid #f5f5f5;">
            <div class="d-flex align-items-center" style="gap:10px;">
              <span style="width:24px;height:24px;border-radius:50%;background:{{ ['#f59e0b','#94a3b8','#cd7f32','#0d1c2e','#2E7D32'][$idx] ?? '#eee' }};color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;">{{ $idx+1 }}</span>
              <div>
                <div style="font-size:13px;font-weight:600;">{{ \Str::limit($vue->annonce?->name ?? '—', 35) }}</div>
                <div style="font-size:11px;color:#888;">{{ $vue->annonce?->commune?->name ?? '' }}</div>
              </div>
            </div>
            <div class="text-end">
              <div style="font-size:16px;font-weight:700;color:#0d1c2e;">{{ $vue->total }}</div>
              <div style="font-size:10px;color:#aaa;">vues</div>
            </div>
          </div>
        @empty
          <p class="text-muted" style="font-size:13px;">Aucune vue enregistrée.</p>
        @endforelse
      </div>
    </div>

    {{-- Tableau vues + contacts --}}
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm p-4">
        <h6 class="mb-3">Détail par annonce</h6>
        <div style="max-height:280px;overflow-y:auto;">
          <table class="table table-sm" style="font-size:12px;">
            <thead class="table-light">
              <tr>
                <th>Annonce</th>
                <th class="text-center">Vues</th>
                <th class="text-center">Contacts</th>
                <th class="text-center">Taux</th>
              </tr>
            </thead>
            <tbody>
              @forelse($vuesParAnnonce as $vue)
                @php
                  $contacts = $contactsParAnnonce[$vue->annonce_id] ?? 0;
                  $taux = $vue->total > 0 ? round($contacts / $vue->total * 100, 1) : 0;
                @endphp
                <tr>
                  <td>
                    @if($vue->annonce)
                      <a href="{{ route('annonce', $vue->annonce->slug) }}" class="text-dark" target="_blank">
                        {{ \Str::limit($vue->annonce->name, 28) }}
                      </a>
                    @else
                      <span class="text-muted">#{{ $vue->annonce_id }}</span>
                    @endif
                  </td>
                  <td class="text-center fw-bold">{{ $vue->total }}</td>
                  <td class="text-center" style="color:#2E7D32;font-weight:600;">{{ $contacts }}</td>
                  <td class="text-center">
                    <span style="font-size:11px;color:{{ $taux >= 5 ? '#059669' : '#888' }};">{{ $taux }}%</span>
                  </td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-center text-muted">Aucune donnée</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Section admin : envoyer notification push --}}
  @php $isAdmin = auth()->user()?->is_admin ?? false; @endphp
  @if($isAdmin)
  <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px;">
    <h6 class="fw-bold mb-3">📢 Envoyer une notification à tous les abonnés</h6>
    @if(session('success') && str_contains(session('success'), 'Notification'))
      <div class="alert alert-success rounded-3 mb-3" style="font-size:13px;">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('push.sendAll') }}">
      @csrf
      <div class="row g-2">
        <div class="col-md-4">
          <input type="text" name="title" class="form-control" placeholder="Titre de la notification" required style="font-size:13px;">
        </div>
        <div class="col-md-5">
          <input type="text" name="body" class="form-control" placeholder="Message (ex: Nouvelle annonce vedette !)" required style="font-size:13px;">
        </div>
        <div class="col-md-2">
          <input type="text" name="url" class="form-control" placeholder="URL (optionnel)" style="font-size:13px;">
        </div>
        <div class="col-md-1">
          <button type="submit" class="btn w-100 fw-bold" style="background:#2E7D32;color:#fff;border-radius:8px;font-size:12px;">
            Envoyer
          </button>
        </div>
      </div>
    </form>
  </div>
  @endif

</div>
</section>
@endsection

@section('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

  // Graphique barres — vues par annonce
  new Chart(document.getElementById('chartBarres'), {
    type: 'bar',
    data: {
      labels: @json($barLabels),
      datasets: [{
        label: 'Vues',
        data: @json($barData),
        backgroundColor: '#2E7D32',
        borderRadius: 6,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 } },
        x: { ticks: { font: { size: 10 } } }
      }
    }
  });

  // Graphique ligne — évolution 30j
  new Chart(document.getElementById('chartLigne'), {
    type: 'line',
    data: {
      labels: @json($labels30j),
      datasets: [{
        label: 'Vues',
        data: @json($data30j),
        borderColor: '#0d1c2e',
        backgroundColor: 'rgba(13,28,46,.08)',
        fill: true,
        tension: 0.3,
        pointRadius: 3,
        pointBackgroundColor: '#2E7D32',
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 } },
        x: { ticks: { font: { size: 10 }, maxTicksLimit: 10 } }
      }
    }
  });

});
</script>
<script>
function copyNumber(el) {
  var num = el.textContent.trim();
  navigator.clipboard.writeText(num).then(function() {
    var orig = el.style.color;
    el.textContent = '✓ Copié !';
    el.style.color = '#2E7D32';
    setTimeout(function() { el.textContent = num; el.style.color = orig; }, 2000);
  }).catch(function() {});
}
</script>
@endsection
