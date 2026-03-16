@extends('layouts.accueil')

@section('title', 'Calculateur de prêt immobilier — ' . config('app.name'))

@section('content')
<section class="section mt-4" style="min-height: 80vh;">
  <div class="container" style="margin-top: 100px;">

    <div class="row justify-content-center">
      <div class="col-lg-10">
        <h4 class="mb-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6m7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58z"/></svg>
          Simulateur de prêt immobilier
        </h4>
        <p class="text-muted mb-4" style="font-size:13px;">Estimez vos mensualités et le coût total de votre crédit immobilier.</p>

        <div class="row g-4">
          {{-- Formulaire --}}
          <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4">
              <div class="mb-3">
                <label class="form-label fw-bold" style="font-size:13px;">Montant du prêt (CFA)</label>
                <input type="number" id="montant" class="form-control" value="20000000" min="100000" step="100000" oninput="calculer()">
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold" style="font-size:13px;">Durée du prêt</label>
                <div class="d-flex align-items-center" style="gap:10px;">
                  <input type="range" id="duree" class="form-range flex-grow-1" min="1" max="30" value="15" oninput="calculer(); document.getElementById('dureeVal').textContent=this.value">
                  <span id="dureeVal" style="min-width:60px;font-weight:600;">15 ans</span>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold" style="font-size:13px;">Taux d'intérêt annuel (%)</label>
                <div class="d-flex align-items-center" style="gap:10px;">
                  <input type="range" id="taux" class="form-range flex-grow-1" min="1" max="20" step="0.1" value="7" oninput="calculer(); document.getElementById('tauxVal').textContent=parseFloat(this.value).toFixed(1)+'%'">
                  <span id="tauxVal" style="min-width:60px;font-weight:600;">7.0%</span>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold" style="font-size:13px;">Apport personnel (CFA)</label>
                <input type="number" id="apport" class="form-control" value="0" min="0" step="100000" oninput="calculer()">
              </div>
            </div>
          </div>

          {{-- Résultats --}}
          <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 h-100">
              <div class="row g-3 mb-4">
                <div class="col-6">
                  <div class="rounded p-3 text-center" style="background:#0d1c2e;color:#fff;">
                    <div style="font-size:11px;opacity:.7;margin-bottom:4px;">Mensualité</div>
                    <div id="mensualite" style="font-size:22px;font-weight:700;color:#2E7D32;">—</div>
                    <div style="font-size:10px;opacity:.6;">CFA / mois</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="rounded p-3 text-center" style="background:#f8f9fa;">
                    <div style="font-size:11px;color:#888;margin-bottom:4px;">Coût total du crédit</div>
                    <div id="coutTotal" style="font-size:22px;font-weight:700;color:#0d1c2e;">—</div>
                    <div style="font-size:10px;color:#aaa;">CFA</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="rounded p-3 text-center" style="background:#fff3cd;">
                    <div style="font-size:11px;color:#888;margin-bottom:4px;">Coût des intérêts</div>
                    <div id="coutInterets" style="font-size:20px;font-weight:700;color:#d97706;">—</div>
                    <div style="font-size:10px;color:#aaa;">CFA</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="rounded p-3 text-center" style="background:#d1fae5;">
                    <div style="font-size:11px;color:#888;margin-bottom:4px;">Capital remboursé</div>
                    <div id="capitalRembourse" style="font-size:20px;font-weight:700;color:#059669;">—</div>
                    <div style="font-size:10px;color:#aaa;">CFA</div>
                  </div>
                </div>
              </div>

              {{-- Pie Chart --}}
              <div class="d-flex justify-content-center">
                <canvas id="pieChart" width="200" height="200"></canvas>
              </div>
              <div class="d-flex justify-content-center mt-2" style="gap:20px;font-size:12px;">
                <span><span style="display:inline-block;width:12px;height:12px;background:#0d1c2e;border-radius:3px;margin-right:4px;"></span>Capital</span>
                <span><span style="display:inline-block;width:12px;height:12px;background:#f59e0b;border-radius:3px;margin-right:4px;"></span>Intérêts</span>
              </div>
            </div>
          </div>
        </div>

        {{-- Tableau d'amortissement --}}
        <div class="card border-0 shadow-sm mt-4 p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Tableau d'amortissement</h6>
            <button class="btn btn-sm btn-light" onclick="toggleTableau()">Afficher / Masquer</button>
          </div>
          <div id="tableau" style="display:none;max-height:300px;overflow-y:auto;">
            <table class="table table-sm table-striped" style="font-size:12px;">
              <thead class="table-dark">
                <tr><th>Année</th><th>Mensualité</th><th>Capital</th><th>Intérêts</th><th>Capital restant</th></tr>
              </thead>
              <tbody id="tableauBody"></tbody>
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
var pieChart = null;

function fmt(n) {
    return Math.round(n).toLocaleString('fr-FR') + ' CFA';
}

function calculer() {
    var montant    = parseFloat(document.getElementById('montant').value) || 0;
    var apport     = parseFloat(document.getElementById('apport').value) || 0;
    var duree      = parseInt(document.getElementById('duree').value) || 1;
    var tauxAnnuel = parseFloat(document.getElementById('taux').value) || 0;

    var capital = montant - apport;
    if (capital <= 0) {
        document.getElementById('mensualite').textContent = '0';
        return;
    }

    var tauxMensuel = tauxAnnuel / 100 / 12;
    var n = duree * 12;
    var mensualite;

    if (tauxMensuel === 0) {
        mensualite = capital / n;
    } else {
        mensualite = capital * tauxMensuel * Math.pow(1 + tauxMensuel, n) / (Math.pow(1 + tauxMensuel, n) - 1);
    }

    var coutTotal   = mensualite * n;
    var interets    = coutTotal - capital;

    document.getElementById('mensualite').textContent     = Math.round(mensualite).toLocaleString('fr-FR');
    document.getElementById('coutTotal').textContent      = fmt(coutTotal);
    document.getElementById('coutInterets').textContent   = fmt(interets);
    document.getElementById('capitalRembourse').textContent = fmt(capital);

    // Pie chart
    var ctx = document.getElementById('pieChart').getContext('2d');
    if (pieChart) pieChart.destroy();
    pieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Capital', 'Intérêts'],
            datasets: [{
                data: [Math.max(0, capital), Math.max(0, interets)],
                backgroundColor: ['#0d1c2e', '#f59e0b'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: false,
            plugins: { legend: { display: false }, tooltip: {
                callbacks: { label: ctx => ' ' + Math.round(ctx.parsed).toLocaleString('fr-FR') + ' CFA' }
            }},
            cutout: '65%',
        }
    });

    // Tableau amortissement
    var tbody = document.getElementById('tableauBody');
    tbody.innerHTML = '';
    var restant = capital;
    for (var annee = 1; annee <= duree; annee++) {
        var interetsAnnee = 0, capitalAnnee = 0;
        for (var m = 0; m < 12; m++) {
            var intM = restant * tauxMensuel;
            var capM = mensualite - intM;
            interetsAnnee += intM;
            capitalAnnee  += capM;
            restant -= capM;
        }
        tbody.innerHTML += `<tr>
            <td>${annee}</td>
            <td>${fmt(mensualite * 12)}</td>
            <td>${fmt(capitalAnnee)}</td>
            <td>${fmt(interetsAnnee)}</td>
            <td>${fmt(Math.max(0, restant))}</td>
        </tr>`;
    }
}

function toggleTableau() {
    var t = document.getElementById('tableau');
    t.style.display = t.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', calculer);
</script>
@endsection
