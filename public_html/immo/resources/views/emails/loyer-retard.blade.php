<!DOCTYPE html>
<html>
<body style="font-family:sans-serif;color:#333;max-width:600px;margin:auto;padding:20px;">
  <div style="background:#c0392b;color:#fff;padding:20px;border-radius:12px 12px 0 0;text-align:center;">
    <h2 style="margin:0;">⚠️ {{ config('app.name') }}</h2>
  </div>
  <div style="background:#fff5f5;padding:24px;border:1px solid #fecaca;">
    <h3 style="color:#c0392b;">Loyer en retard</h3>
    <p>Bonjour {{ $contrat->agent?->name }},</p>
    <p>Le loyer pour le bien <strong>{{ $contrat->annonce?->name }}</strong> (locataire : {{ $contrat->locataire?->name ?? $contrat->locataire?->email }}) n'a pas encore été reçu pour ce mois.</p>
    <div style="background:#fff;border:1px solid #e74c3c;border-radius:10px;padding:15px;margin:15px 0;">
      <p style="margin:0;color:#c0392b;"><strong>Montant attendu : {{ number_format($contrat->loyer_mensuel,0,',',' ') }} CFA</strong></p>
    </div>
    <p>Veuillez contacter le locataire ou mettre à jour le statut dans votre espace de gestion locative.</p>
  </div>
  <div style="background:#c0392b;color:#fff;padding:12px;text-align:center;border-radius:0 0 12px 12px;font-size:11px;">
    {{ config('app.name') }} — Plateforme immobilière au Sénégal
  </div>
</body>
</html>
