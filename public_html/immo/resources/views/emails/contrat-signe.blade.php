<!DOCTYPE html>
<html>
<body style="font-family:sans-serif;color:#333;max-width:600px;margin:auto;padding:20px;">
  <div style="background:#0d1c2e;color:#fff;padding:20px;border-radius:12px 12px 0 0;text-align:center;">
    <h2 style="margin:0;">✍️ {{ config('app.name') }}</h2>
  </div>
  <div style="background:#f8fffe;padding:24px;border:1px solid #e8fdf8;">
    <h3 style="color:#0d1c2e;">Votre contrat de location est signé !</h3>
    <p>Le contrat de location N° <strong>{{ $contrat->id }}</strong> pour le bien <strong>{{ $contrat->annonce?->name }}</strong> a été signé par les deux parties.</p>
    <div style="background:#fff;border:1px solid #27E3C0;border-radius:10px;padding:15px;margin:15px 0;">
      <p style="margin:0;"><strong>Agent :</strong> {{ $contrat->agent?->name ?? $contrat->agent?->email }}</p>
      <p style="margin:5px 0 0;"><strong>Locataire :</strong> {{ $contrat->locataire?->name ?? $contrat->locataire?->email }}</p>
      <p style="margin:5px 0 0;"><strong>Loyer :</strong> {{ number_format($contrat->loyer_mensuel,0,',',' ') }} CFA/mois</p>
    </div>
    <p>Le contrat PDF signé est joint à cet email. Conservez-le précieusement.</p>
  </div>
  <div style="background:#0d1c2e;color:#27E3C0;padding:12px;text-align:center;border-radius:0 0 12px 12px;font-size:11px;">
    {{ config('app.name') }} — Plateforme immobilière au Sénégal
  </div>
</body>
</html>
