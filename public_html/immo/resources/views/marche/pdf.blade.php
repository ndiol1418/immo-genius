<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
  h1 { color: #0d1c2e; font-size: 22px; border-bottom: 3px solid #2E7D32; padding-bottom: 10px; }
  h2 { color: #2E7D32; font-size: 15px; margin-top: 24px; }
  table { width: 100%; border-collapse: collapse; margin-top: 10px; }
  th { background: #0d1c2e; color: #fff; padding: 7px 10px; text-align: left; font-size: 11px; }
  td { padding: 6px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
  tr:nth-child(even) td { background: #f8f9fa; }
  .kpi { display: inline-block; background: #f0f4f8; border-left: 4px solid #2E7D32; padding: 10px 16px; margin: 6px; border-radius: 6px; min-width: 140px; }
  .kpi-val { font-size: 20px; font-weight: 800; color: #2E7D32; }
  .kpi-lab { font-size: 10px; color: #888; }
  .footer { margin-top: 40px; font-size: 10px; color: #aaa; text-align: center; border-top: 1px solid #eee; padding-top: 10px; }
</style>
</head>
<body>

<h1>📊 Rapport Marché Immobilier Sénégalais</h1>
<p style="color:#888;">Généré le {{ now()->format('d/m/Y à H:i') }} — {{ config('app.name') }}</p>

<h2>Indicateurs clés</h2>
<div>
  <div class="kpi">
    <div class="kpi-val">{{ number_format($prixMoyenM2, 0, ',', ' ') }} CFA</div>
    <div class="kpi-lab">Prix moyen / m²</div>
  </div>
  <div class="kpi">
    <div class="kpi-val">{{ number_format($totalAnnonces) }}</div>
    <div class="kpi-lab">Annonces actives</div>
  </div>
</div>

<h2>Annonces actives par type de bien</h2>
<table>
  <thead><tr><th>Type de bien</th><th>Nb annonces</th></tr></thead>
  <tbody>
    @foreach($annoncesParType as $t)
    <tr>
      <td>{{ $t->name }}</td>
      <td>{{ $t->annonces_count }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<h2>Prix moyen par commune (Top 20)</h2>
<table>
  <thead><tr><th>Rang</th><th>Commune</th><th>Prix moyen (CFA)</th><th>Nb annonces</th></tr></thead>
  <tbody>
    @foreach($prixParCommune as $i => $zone)
    <tr>
      <td>{{ $i+1 }}</td>
      <td>{{ $zone->name }}</td>
      <td>{{ number_format($zone->prix_moyen, 0, ',', ' ') }}</td>
      <td>{{ $zone->nb_annonces }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="footer">
  {{ config('app.name') }} · Rapport généré automatiquement · {{ now()->format('d/m/Y') }}
</div>

</body>
</html>
