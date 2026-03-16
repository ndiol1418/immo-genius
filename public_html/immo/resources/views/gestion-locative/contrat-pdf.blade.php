<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
  .header { text-align: center; border-bottom: 3px solid #2E7D32; padding-bottom: 15px; margin-bottom: 20px; }
  h1 { font-size: 20px; color: #0d1c2e; }
  h2 { font-size: 14px; color: #0d1c2e; border-left: 4px solid #2E7D32; padding-left: 8px; margin-top: 20px; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
  td, th { padding: 7px 10px; border: 1px solid #ddd; }
  th { background: #f0f0f0; font-weight: bold; }
  .sig-box { border: 1px solid #ccc; padding: 10px; min-height: 80px; border-radius: 5px; text-align: center; }
  .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #999; }
</style>
</head>
<body>
  <div class="header">
    <h1>🏠 {{ config('app.name') }}</h1>
    <h2 style="border:none;padding:0;">CONTRAT DE LOCATION N° {{ $contrat->id }}</h2>
    <p style="color:#666;font-size:11px;">Établi le {{ now()->format('d/m/Y') }}</p>
  </div>

  <h2>ARTICLE 1 — PARTIES</h2>
  <table>
    <tr><th>Bailleur (Agent)</th><td>{{ $contrat->agent?->name ?? $contrat->agent?->email }}</td></tr>
    <tr><th>Locataire</th><td>{{ $contrat->locataire?->name ?? $contrat->locataire?->email }}</td></tr>
  </table>

  <h2>ARTICLE 2 — BIEN LOUÉ</h2>
  <table>
    <tr><th>Désignation</th><td>{{ $contrat->annonce?->name }}</td></tr>
    <tr><th>Adresse</th><td>{{ $contrat->annonce?->adresse ?? '—' }}</td></tr>
    <tr><th>Surface</th><td>{{ $contrat->annonce?->superficie ?? '—' }} m²</td></tr>
  </table>

  <h2>ARTICLE 3 — CONDITIONS FINANCIÈRES</h2>
  <table>
    <tr><th>Loyer mensuel</th><td>{{ number_format($contrat->loyer_mensuel,0,',',' ') }} CFA</td></tr>
    <tr><th>Charges mensuelles</th><td>{{ number_format($contrat->charges,0,',',' ') }} CFA</td></tr>
    <tr><th>Dépôt de garantie</th><td>{{ number_format($contrat->caution,0,',',' ') }} CFA</td></tr>
    <tr><th>Total mensuel</th><td><strong>{{ number_format($contrat->loyer_mensuel + $contrat->charges,0,',',' ') }} CFA</strong></td></tr>
  </table>

  <h2>ARTICLE 4 — DURÉE</h2>
  <table>
    <tr><th>Date de début</th><td>{{ $contrat->date_debut->format('d/m/Y') }}</td></tr>
    <tr><th>Date de fin</th><td>{{ $contrat->date_fin?->format('d/m/Y') ?? 'Durée indéterminée' }}</td></tr>
  </table>

  <h2>ARTICLE 5 — SIGNATURES</h2>
  <table>
    <tr>
      <th style="width:50%;text-align:center;">Signature du Bailleur</th>
      <th style="width:50%;text-align:center;">Signature du Locataire</th>
    </tr>
    <tr>
      <td style="text-align:center;padding:10px;">
        @if($contrat->signature_agent)
          <img src="{{ $contrat->signature_agent }}" style="max-width:200px;max-height:80px;" alt="Signature bailleur">
          <br><small>Signé le {{ $contrat->date_signature_agent?->format('d/m/Y') }}</small>
        @else
          <div class="sig-box" style="color:#ccc;">Non signé</div>
        @endif
      </td>
      <td style="text-align:center;padding:10px;">
        @if($contrat->signature_locataire)
          <img src="{{ $contrat->signature_locataire }}" style="max-width:200px;max-height:80px;" alt="Signature locataire">
          <br><small>Signé le {{ $contrat->date_signature_locataire?->format('d/m/Y') }}</small>
        @else
          <div class="sig-box" style="color:#ccc;">Non signé</div>
        @endif
      </td>
    </tr>
  </table>

  <div class="footer">
    Document généré le {{ now()->format('d/m/Y H:i') }} — {{ config('app.name') }} — Contrat légalement opposable une fois signé par les deux parties.
  </div>
</body>
</html>
