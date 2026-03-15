<!DOCTYPE html>
<html>
<body style="font-family:sans-serif;color:#333;max-width:600px;margin:auto;padding:20px;">
  <div style="background:#0d1c2e;color:#fff;padding:20px;border-radius:12px 12px 0 0;text-align:center;">
    <h2 style="margin:0;">🏠 {{ config('app.name') }}</h2>
  </div>
  <div style="background:#f8fffe;padding:24px;border:1px solid #e8fdf8;">
    <h3 style="color:#0d1c2e;">Rappel d'échéance de loyer</h3>
    <p>Bonjour {{ $contrat->locataire?->name }},</p>
    <p>Votre loyer mensuel pour le bien <strong>{{ $contrat->annonce?->name }}</strong> est dû dans <strong>5 jours</strong>.</p>
    <div style="background:#fff;border:1px solid #27E3C0;border-radius:10px;padding:15px;margin:15px 0;">
      <p style="margin:0;"><strong>Montant :</strong> {{ number_format($contrat->loyer_mensuel,0,',',' ') }} CFA</p>
      <p style="margin:5px 0 0;"><strong>Charges :</strong> {{ number_format($contrat->charges,0,',',' ') }} CFA</p>
    </div>
    <p>Merci de vous assurer que le paiement est effectué à temps.</p>
  </div>
  <div style="background:#0d1c2e;color:#27E3C0;padding:12px;text-align:center;border-radius:0 0 12px 12px;font-size:11px;">
    {{ config('app.name') }} — Plateforme immobilière au Sénégal
  </div>
</body>
</html>
