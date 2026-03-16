@extends('layouts.accueil')
@section('title', 'Blog — Actualités Immobilières | ' . config('app.name'))

@section('content')
<section class="section" style="padding-top:110px;min-height:80vh;">
<div class="container">

  {{-- Header --}}
  <div class="text-center mb-5">
    <h2 class="fw-bold">📰 Actualités Immobilières</h2>
    <p class="text-muted" style="font-size:14px;">Guides, conseils et analyses du marché immobilier sénégalais</p>
  </div>

  {{-- Filtres catégorie --}}
  <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
    @php
      $categories = [
        ''          => ['label' => 'Tous', 'color' => '#0d1c2e'],
        'actualite' => ['label' => 'Actualité', 'color' => '#0d1c2e'],
        'guide'     => ['label' => 'Guide', 'color' => '#2E7D32'],
        'conseil'   => ['label' => 'Conseil', 'color' => '#C49A0C'],
        'marche'    => ['label' => 'Marché', 'color' => '#6366f1'],
        'quartier'  => ['label' => 'Quartier', 'color' => '#dc3545'],
      ];
    @endphp
    @foreach($categories as $key => $cat)
    <a href="{{ route('blog.index', $key ? ['categorie' => $key] : []) }}"
       style="background:{{ $categorie == $key ? $cat['color'] : '#f8f9fa' }};color:{{ $categorie == $key ? '#fff' : $cat['color'] }};border:2px solid {{ $cat['color'] }};border-radius:20px;padding:6px 18px;font-size:12px;font-weight:600;text-decoration:none;">
      {{ $cat['label'] }}
    </a>
    @endforeach
  </div>

  {{-- Grille articles --}}
  @if($articles->isEmpty())
    <div class="text-center text-muted py-5">Aucun article pour l'instant. Revenez bientôt !</div>
  @else
  <div class="row g-4 mb-5">
    @foreach($articles as $article)
    @php
      $couleur = $article->categorie_couleur;
      $label   = $article->categorie_libelle;
    @endphp
    <div class="col-lg-4 col-md-6">
      <div class="card border-0 shadow-sm h-100" style="border-radius:16px;overflow:hidden;transition:transform .2s;" onmouseenter="this.style.transform='translateY(-4px)'" onmouseleave="this.style.transform='none'">
        {{-- Image --}}
        <div style="height:200px;overflow:hidden;background:#f0f4f8;position:relative;">
          @if($article->image_couverture)
            <img src="{{ asset($article->image_couverture) }}" alt="{{ $article->titre }}" style="width:100%;height:100%;object-fit:cover;">
          @else
            <div style="height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;">
              {{ $article->categorie === 'guide' ? '📖' : ($article->categorie === 'conseil' ? '💡' : ($article->categorie === 'marche' ? '📊' : ($article->categorie === 'quartier' ? '🗺️' : '📰'))) }}
            </div>
          @endif
          <span style="position:absolute;top:12px;left:12px;background:{{ $couleur }};color:#fff;font-size:10px;font-weight:700;padding:3px 12px;border-radius:20px;">{{ $label }}</span>
        </div>
        {{-- Body --}}
        <div class="p-4 d-flex flex-column" style="flex:1;">
          <h6 class="fw-bold mb-2" style="line-height:1.4;">{{ $article->titre }}</h6>
          <p class="text-muted mb-3" style="font-size:13px;flex:1;">{{ \Str::limit($article->extrait ?? strip_tags($article->contenu), 130) }}</p>
          <div class="d-flex align-items-center justify-content-between mt-auto" style="font-size:11px;color:#aaa;">
            <span>{{ $article->created_at->format('d/m/Y') }} · {{ $article->auteur?->name ?? 'Teranga' }}</span>
            <span>👁 {{ number_format($article->vues) }}</span>
          </div>
          <a href="{{ route('blog.show', $article->slug) }}" class="btn btn-sm mt-3 fw-bold"
             style="background:#2E7D32;color:#fff;border-radius:8px;font-size:12px;">
            Lire la suite →
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Pagination --}}
  <div class="d-flex justify-content-center">
    {{ $articles->links() }}
  </div>
  @endif

</div>
</section>
@endsection
