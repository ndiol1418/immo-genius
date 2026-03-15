@extends('layouts.accueil')

@section('title', 'Analytics — ' . config('app.name'))

@section('content')
<section class="section mt-4" style="min-height:80vh;">
<div class="container" style="margin-top:100px;">

  <div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0">
      <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M16 11.78L20.24 4.45L21.97 5.45L16.74 14.5L10.23 10.75L5.46 19H22V21H2V3H4V17.54L9.5 8L16 11.78Z"/></svg>
      Dashboard Analytics
    </h4>
    <span class="text-muted" style="font-size:13px;">Agent : <strong>{{ $agent->nom_complet }}</strong></span>
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
        <div style="font-size:28px;font-weight:700;color:#27E3C0;">{{ number_format($totalContacts) }}</div>
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
              <span style="width:24px;height:24px;border-radius:50%;background:{{ ['#f59e0b','#94a3b8','#cd7f32','#0d1c2e','#27E3C0'][$idx] ?? '#eee' }};color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;">{{ $idx+1 }}</span>
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
                  <td class="text-center" style="color:#27E3C0;font-weight:600;">{{ $contacts }}</td>
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
        backgroundColor: '#27E3C0',
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
        pointBackgroundColor: '#27E3C0',
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
@endsection
