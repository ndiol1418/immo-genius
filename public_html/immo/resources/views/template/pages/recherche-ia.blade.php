@extends('layouts.accueil')

@section('title', 'Recherche IA — ' . config('app.name'))

@section('content')
<section class="section" style="padding-top:110px;min-height:80vh;">
  <div class="container">

    {{-- En-tête résultats IA --}}
    <div class="mb-4 p-4 rounded-3" style="background:#f1f8e9;border-left:5px solid #2E7D32;">
      <div class="d-flex align-items-start gap-2 flex-wrap">
        <span style="font-size:22px;">🤖</span>
        <div class="flex-grow-1">
          <div style="font-size:13px;color:#666;margin-bottom:6px;">Recherche IA</div>
          <div class="fw-bold" style="font-size:16px;color:#0d1c2e;">"{{ $texte }}"</div>
          <div class="mt-2 d-flex flex-wrap gap-2">
            @foreach($criteresBadges as $badge)
              <span class="badge px-3 py-2 rounded-pill" style="background:{{ $badge['color'] }};font-size:12px;">
                {{ $badge['label'] }}
              </span>
            @endforeach
            @if(empty($criteresBadges))
              <span class="badge bg-secondary px-3 py-2 rounded-pill" style="font-size:12px;">Recherche générale</span>
            @endif
          </div>
          <div class="mt-2" style="font-size:13px;color:#2E7D32;font-weight:600;">
            J'ai trouvé <strong>{{ $annonces->total() }}</strong> annonce(s) correspondant à votre recherche
          </div>
        </div>
        <a href="/" class="btn btn-sm" style="background:#2E7D32;color:#fff;border-radius:8px;font-size:12px;">
          ✏️ Modifier les critères
        </a>
      </div>
    </div>

    {{-- Résultats --}}
    @if($annonces->isEmpty())
    <div class="text-center py-5">
      <div style="font-size:48px;margin-bottom:16px;">🔍</div>
      <h5>Aucune annonce trouvée</h5>
      <p class="text-muted" style="font-size:13px;">Essayez de reformuler votre recherche ou d'élargir vos critères.</p>
      <a href="/" class="btn" style="background:#2E7D32;color:#fff;border-radius:10px;">Retour à l'accueil</a>
    </div>
    @else
    <div class="row">
      @foreach($annonces as $annonce)
        @include('template.components.c_annonce_2', ['annonce' => $annonce, 'col' => 'col-12 col-sm-6 col-lg-4'])
      @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
      {{ $annonces->appends(['q' => $texte])->links() }}
    </div>
    @endif

  </div>
</section>
@endsection
