@extends('layouts.accueil')

@section('title', 'Mes Favoris — ' . config('app.name'))

@section('content')
<section class="services section mt-4" style="min-height: 60vh;">
  <div class="container" style="margin-top: 100px;">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h4 class="mb-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24" style="color:#e74c3c"><path fill="currentColor" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54z"/></svg>
        Mes Favoris
        <span class="badge" style="background:#27E3C0;color:#fff;border-radius:20px;font-size:13px;">{{ $favoris->count() }}</span>
      </h4>
      <a href="{{ route('accueil') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:20px;">Voir les annonces</a>
    </div>

    @if($favoris->isEmpty())
      <div class="text-center py-5">
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" style="color:#ddd"><path fill="currentColor" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54z"/></svg>
        <p class="text-muted mt-3" style="font-size:16px;">Aucun favori pour l'instant</p>
        <a href="{{ route('accueil') }}" class="btn btn-sm" style="background:#27E3C0;color:#fff;border-radius:20px;">Parcourir les annonces</a>
      </div>
    @else
      <div class="row">
        @foreach($favoris as $favori)
          @if($favori->annonce)
          @php $annonce = $favori->annonce; @endphp
          <div class="col-12 col-sm-6 col-lg-4 mb-4">
            <div class="_card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
              <div style="position:relative;">
                <a href="{{ route('annonce', $annonce->slug) }}">
                  <img src="{{ asset($annonce->images && count($annonce->images) ? $annonce->images[0]->url : 'img/home.jpeg') }}"
                       alt="{{ $annonce->name }}" style="width:100%;height:180px;object-fit:cover;">
                </a>
                <form method="POST" action="{{ route('favoris.toggle', $annonce->id) }}" style="position:absolute;top:10px;right:10px;">
                  @csrf
                  <button type="submit" style="background:rgba(255,255,255,.9);border:none;border-radius:50%;width:34px;height:34px;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#e74c3c"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54z"/></svg>
                  </button>
                </form>
              </div>
              <div class="p-3">
                <a href="{{ route('annonce', $annonce->slug) }}" style="text-decoration:none;color:inherit;">
                  <p style="font-weight:bold;margin:0;font-size:16px;color:#27E3C0;">{{ number_format($annonce->prix, 0, '', ' ') }} CFA</p>
                  <p style="font-size:13px;font-weight:600;margin:4px 0;">{{ $annonce->name }}</p>
                  <p style="font-size:11px;color:#888;margin:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="currentColor" d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4s-4 1.794-4 4s1.794 4 4 4"/><path fill="currentColor" d="M11.42 21.814a1 1 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819M12 4c3.309 0 6 2.691 6 6.005c.021 4.438-4.388 8.423-6 9.73c-1.611-1.308-6.021-5.294-6-9.735c0-3.309 2.691-6 6-6"/></svg>
                    {{ $annonce->adresse }}@if($annonce->commune), {{ $annonce->commune->name }}@endif
                  </p>
                </a>
              </div>
            </div>
          </div>
          @endif
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection
