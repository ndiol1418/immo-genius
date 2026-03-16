@extends('layouts.accueil')
@section('title', 'Marché Immobilier Sénégalais | ' . config('app.name'))

@section('content')
<section class="section" style="padding-top:110px;min-height:80vh;">
<div class="container">

  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
      <h2 class="fw-bold mb-1">📊 Marché Immobilier Sénégalais</h2>
      <p class="text-muted mb-0" style="font-size:14px;">Données en temps réel — Mis à jour le {{ now()->format('d/m/Y') }}</p>
    </div>
    <a href="{{ route('marche.pdf') }}" class="btn fw-bold"
       style="background:#0d1c2e;color:#fff;border-radius:10px;font-size:13px;">
      📥 Télécharger le rapport PDF
    </a>
  </div>

  {{-- ═══ Section 1 — Indicateurs clés ═══ --}}
  <div class="row g-3 mb-5">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 text-center h-100" style="border-radius:14px;">
        <div style="font-size:10px;color:#888;font-weight:700;letter-spacing:1px;margin-bottom:8px;">PRIX MOYEN / M² DAKAR</div>
        <div style="font-size:26px;font-weight:800;color:#2E7D32;">{{ number_format($prixMoyenM2, 0, ',', ' ') }}</div>
        <div style="font-size:11px;color:#aaa;">CFA / m²</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 text-center h-100" style="border-radius:14px;">
        <div style="font-size:10px;color:#888;font-weight:700;letter-spacing:1px;margin-bottom:8px;">ANNONCES ACTIVES</div>
        <div style="font-size:26px;font-weight:800;color:#0d1c2e;">{{ number_format($totalAnnonces) }}</div>
        <div style="font-size:11px;color:#aaa;">en ligne</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 text-center h-100" style="border-radius:14px;">
        <div style="font-size:10px;color:#888;font-weight:700;letter-spacing:1px;margin-bottom:8px;">VARIATION 30 JOURS</div>
        <div style="font-size:26px;font-weight:800;color:{{ $variation30j >= 0 ? '#2E7D32' : '#dc3545' }};">
          {{ $variation30j >= 0 ? '+' : '' }}{{ $variation30j }}%
        </div>
        <div style="font-size:11px;color:#aaa;">nouvelles annonces</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 text-center h-100" style="border-radius:14px;">
        <div style="font-size:10px;color:#888;font-weight:700;letter-spacing:1px;margin-bottom:8px;">TYPES DE BIENS</div>
        <div style="font-size:26px;font-weight:800;color:#6366f1;">{{ $annoncesParType->count() }}</div>
        <div style="font-size:11px;color:#aaa;">catégories</div>
      </div>
    </div>
  </div>

  {{-- ═══ Section 2 — Prix par zone ═══ --}}
  <div class="card border-0 shadow-sm p-4 mb-5" style="border-radius:16px;">
    <h5 class="fw-bold mb-4">🗺️ Prix moyen par commune</h5>
    <div class="table-responsive">
      <table class="table table-sm align-middle" style="font-size:13px;">
        <thead style="background:#f8f9fa;">
          <tr>
            <th class="py-2">Rang</th>
            <th>Commune</th>
            <th class="text-end">Prix moyen</th>
            <th class="text-center">Nb annonces</th>
            <th>Tendance</th>
          </tr>
        </thead>
        <tbody>
          @forelse($prixParCommune as $i => $zone)
          <tr>
            <td>
              <span style="width:26px;height:26px;border-radius:50%;background:{{ $i<3 ? '#2E7D32' : '#e9ecef' }};color:{{ $i<3 ? '#fff' : '#333' }};display:inline-flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;">{{ $i+1 }}</span>
            </td>
            <td class="fw-bold">{{ $zone->name }}</td>
            <td class="text-end fw-bold" style="color:#2E7D32;">{{ number_format($zone->prix_moyen, 0, ',', ' ') }} CFA</td>
            <td class="text-center">{{ $zone->nb_annonces }}</td>
            <td>
              @if($i < 5)
                <span style="color:#2E7D32;font-size:13px;">↑ Élevé</span>
              @elseif($i < 10)
                <span style="color:#C49A0C;font-size:13px;">→ Stable</span>
              @else
                <span style="color:#888;font-size:13px;">↓ Modéré</span>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">Aucune donnée disponible.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- ═══ Section 3 — Graphiques ═══ --}}
  <div class="row g-4 mb-5">

    {{-- Camembert --}}
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm p-4 h-100" style="border-radius:16px;">
        <h6 class="fw-bold mb-3">Répartition par type</h6>
        <canvas id="chartPie" height="260"></canvas>
      </div>
    </div>

    {{-- Barres --}}
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm p-4 h-100" style="border-radius:16px;">
        <h6 class="fw-bold mb-3">Prix moyen par type</h6>
        <canvas id="chartBar" height="260"></canvas>
      </div>
    </div>

    {{-- Ligne --}}
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm p-4 h-100" style="border-radius:16px;">
        <h6 class="fw-bold mb-3">Évolution 6 mois</h6>
        <canvas id="chartLine" height="260"></canvas>
      </div>
    </div>

  </div>

  {{-- ═══ Section 4 — Prix par type ═══ --}}
  <div class="card border-0 shadow-sm p-4 mb-5" style="border-radius:16px;">
    <h5 class="fw-bold mb-4">🏠 Prix moyen par type de bien</h5>
    <div class="row g-3">
      @foreach($prixParType as $pt)
      <div class="col-md-4 col-6">
        <div style="background:#f8f9fa;border-radius:12px;padding:16px 20px;border-left:4px solid #2E7D32;">
          <div style="font-size:12px;color:#888;margin-bottom:4px;">{{ $pt->name }}</div>
          <div style="font-size:18px;font-weight:800;color:#2E7D32;">{{ number_format($pt->prix_moyen, 0, ',', ' ') }} <span style="font-size:11px;font-weight:400;color:#aaa;">CFA</span></div>
          <div style="font-size:11px;color:#aaa;">{{ $pt->nb }} annonce(s)</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- CTA Rapport --}}
  <div class="text-center mb-5">
    <div class="card border-0 shadow-sm p-5" style="border-radius:20px;background:linear-gradient(135deg,#0d1c2e,#1a3a5c);">
      <h4 class="text-white fw-bold mb-2">📥 Rapport complet du marché</h4>
      <p class="text-white-50 mb-4" style="font-size:14px;">Téléchargez notre analyse complète en PDF avec toutes les statistiques</p>
      <a href="{{ route('marche.pdf') }}" class="btn btn-lg fw-bold px-5"
         style="background:#2E7D32;color:#fff;border-radius:12px;">
        Télécharger le rapport PDF
      </a>
    </div>
  </div>

</div>
</section>
@endsection

@section('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

  const pieColors = ['#2E7D32','#0d1c2e','#C49A0C','#6366f1','#dc3545','#f59e0b','#06b6d4','#8b5cf6'];

  // Camembert
  new Chart(document.getElementById('chartPie'), {
    type: 'doughnut',
    data: {
      labels: @json($pieLabels),
      datasets: [{ data: @json($pieData), backgroundColor: pieColors, borderWidth: 2 }]
    },
    options: { responsive:true, plugins: { legend: { position:'bottom', labels:{font:{size:10}} } } }
  });

  // Barres
  new Chart(document.getElementById('chartBar'), {
    type: 'bar',
    data: {
      labels: @json($barLabels),
      datasets: [{ label:'Prix moyen (CFA)', data: @json($barData), backgroundColor:'#2E7D32', borderRadius:6 }]
    },
    options: {
      responsive:true,
      plugins: { legend:{display:false} },
      scales: {
        y:{ beginAtZero:true, ticks:{ callback: v => (v/1000000).toFixed(1)+'M' } },
        x:{ ticks:{ font:{size:9} } }
      }
    }
  });

  // Ligne
  new Chart(document.getElementById('chartLine'), {
    type: 'line',
    data: {
      labels: @json($ligneLabels),
      datasets: [{
        label: 'Annonces',
        data: @json($ligneData),
        borderColor: '#0d1c2e',
        backgroundColor: 'rgba(13,28,46,.08)',
        fill: true, tension:0.35, pointRadius:4, pointBackgroundColor:'#2E7D32'
      }]
    },
    options: {
      responsive:true,
      plugins: { legend:{display:false} },
      scales: { y:{ beginAtZero:true, ticks:{precision:0} } }
    }
  });

});
</script>
@endsection
