<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; margin: 0; padding: 20px; }
  .header { text-align: center; border-bottom: 3px solid #2E7D32; padding-bottom: 15px; margin-bottom: 20px; }
  .header h1 { font-size: 22px; color: #0d1c2e; margin: 0 0 4px; }
  .header p { margin: 0; color: #666; font-size: 12px; }
  .badge { background: #2E7D32; color: #0d1c2e; padding: 2px 10px; border-radius: 10px; font-weight: bold; font-size: 11px; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
  td, th { padding: 8px 10px; border: 1px solid #ddd; font-size: 12px; }
  th { background: #0d1c2e; color: #fff; }
  .footer { margin-top: 30px; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
  .montant { font-size: 20px; font-weight: bold; color: #2E7D32; }
</style>
</head>
<body>
  <div class="header">
    <h1>🏠 {{ config('app.name') }}</h1>
    <p>Plateforme immobilière au Sénégal</p>
    <br>
    <h2 style="color:#0d1c2e;font-size:18px;">QUITTANCE DE LOYER</h2>
    <span class="badge">{{ \Carbon\Carbon::createFromFormat('Y-m', $mois)->translatedFormat('F Y') }}</span>
  </div>

  <table>
    <tr><th colspan="2">Informations du bien</th></tr>
    <tr><td>Bien loué</td><td>{{ $contrat->annonce?->name }}</td></tr>
    <tr><td>Adresse</td><td>{{ $contrat->annonce?->adresse ?? '—' }}</td></tr>
  </table>

  <table>
    <tr><th colspan="2">Parties</th></tr>
    <tr><td>Bailleur (Agent)</td><td>{{ $contrat->agent?->name ?? $contrat->agent?->email }}</td></tr>
    <tr><td>Locataire</td><td>{{ $contrat->locataire?->name ?? $contrat->locataire?->email }}</td></tr>
  </table>

  <table>
    <tr><th colspan="2">Détails du paiement</th></tr>
    <tr><td>Mois concerné</td><td>{{ \Carbon\Carbon::createFromFormat('Y-m', $mois)->translatedFormat('F Y') }}</td></tr>
    <tr><td>Loyer mensuel</td><td>{{ number_format($contrat->loyer_mensuel,0,',',' ') }} CFA</td></tr>
    <tr><td>Charges</td><td>{{ number_format($contrat->charges,0,',',' ') }} CFA</td></tr>
    <tr><td><strong>Total payé</strong></td><td class="montant">{{ number_format($paiement->montant,0,',',' ') }} CFA</td></tr>
    <tr><td>Date de paiement</td><td>{{ $paiement->date_paiement?->format('d/m/Y') }}</td></tr>
    <tr><td>Statut</td><td>✓ PAYÉ</td></tr>
  </table>

  <p style="margin-top:20px;">Je soussigné(e) <strong>{{ $contrat->agent?->name ?? $contrat->agent?->email }}</strong>, bailleur, reconnais avoir reçu de <strong>{{ $contrat->locataire?->name ?? $contrat->locataire?->email }}</strong> la somme de <span class="montant">{{ number_format($paiement->montant,0,',',' ') }} CFA</span> correspondant au loyer du mois de <strong>{{ \Carbon\Carbon::createFromFormat('Y-m', $mois)->translatedFormat('F Y') }}</strong>.</p>

  <div class="footer">
    Quittance générée le {{ now()->format('d/m/Y') }} — {{ config('app.name') }} — Cette quittance tient lieu de reçu légal.
  </div>
</body>
</html>
