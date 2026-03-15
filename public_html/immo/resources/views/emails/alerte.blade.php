<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nouvelles annonces — {{ config('app.name') }}</title>
<style>
  body { font-family: 'Nunito', Arial, sans-serif; background: #f4f6f8; margin: 0; padding: 0; }
  .container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
  .header { background: #061630; padding: 28px 30px; text-align: center; }
  .header img { height: 40px; }
  .header h2 { color: #27E3C0; margin: 12px 0 4px; font-size: 20px; }
  .header p { color: #aaa; font-size: 13px; margin: 0; }
  .body { padding: 24px 30px; }
  .alerte-box { background: #f0fdf9; border-left: 4px solid #27E3C0; border-radius: 6px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #333; }
  .alerte-box span { display: inline-block; background: #27E3C0; color: #fff; border-radius: 20px; padding: 2px 10px; margin: 2px 3px; font-size: 11px; }
  .card { border: 1px solid #e8e8e8; border-radius: 10px; overflow: hidden; margin-bottom: 18px; }
  .card img { width: 100%; height: 160px; object-fit: cover; }
  .card-body { padding: 14px 16px; }
  .card-body h4 { margin: 0 0 4px; font-size: 15px; color: #061630; }
  .card-body .prix { color: #27E3C0; font-weight: bold; font-size: 16px; margin: 0 0 6px; }
  .card-body .adresse { font-size: 12px; color: #777; margin: 0 0 10px; }
  .btn { display: inline-block; background: #27E3C0; color: #fff !important; text-decoration: none; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: bold; }
  .footer { background: #f4f6f8; text-align: center; padding: 18px; font-size: 11px; color: #aaa; }
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}">
    <h2>Nouvelles annonces pour vous !</h2>
    <p>{{ $annonces->count() }} annonce(s) correspondent à votre alerte</p>
  </div>
  <div class="body">
    <div class="alerte-box">
      <strong>Votre alerte :</strong><br>
      @if($alerte->type_transaction) <span>{{ ucfirst($alerte->type_transaction) }}</span> @endif
      @if($alerte->type_bien) <span>{{ $alerte->type_bien }}</span> @endif
      @if($alerte->region) <span>{{ $alerte->region }}</span> @endif
      @if($alerte->commune) <span>{{ $alerte->commune }}</span> @endif
      @if($alerte->prix_min) <span>Min {{ number_format($alerte->prix_min, 0, '', ' ') }} CFA</span> @endif
      @if($alerte->prix_max) <span>Max {{ number_format($alerte->prix_max, 0, '', ' ') }} CFA</span> @endif
      @if($alerte->chambres_min) <span>{{ $alerte->chambres_min }}+ chambres</span> @endif
    </div>

    @foreach($annonces as $annonce)
    <div class="card">
      @if($annonce->images && count($annonce->images))
      <img src="{{ asset($annonce->images[0]->url) }}" alt="{{ $annonce->name }}">
      @endif
      <div class="card-body">
        <h4>{{ $annonce->name }}</h4>
        <p class="prix">{{ number_format($annonce->prix, 0, '', ' ') }} CFA</p>
        <p class="adresse">
          {{ $annonce->adresse }}
          @if($annonce->commune) — {{ $annonce->commune->name }} @endif
        </p>
        <a href="{{ route('annonce', $annonce->slug) }}" class="btn">Voir l'annonce</a>
      </div>
    </div>
    @endforeach
  </div>
  <div class="footer">
    Vous recevez cet email car vous avez créé une alerte sur {{ config('app.name') }}.<br>
    Rendez-vous sur <a href="{{ config('app.url') }}/mes-alertes" style="color:#27E3C0">Mes Alertes</a> pour gérer vos alertes.
  </div>
</div>
</body>
</html>
