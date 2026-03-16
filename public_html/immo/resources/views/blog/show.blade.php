@extends('layouts.accueil')
@section('title', $article->titre . ' | ' . config('app.name'))

@section('meta')
  <meta name="description" content="{{ \Str::limit(strip_tags($article->extrait ?? $article->contenu), 160) }}">
  <meta property="og:title"       content="{{ $article->titre }}">
  <meta property="og:description" content="{{ \Str::limit(strip_tags($article->contenu), 160) }}">
  @if($article->image_couverture)
  <meta property="og:image" content="{{ asset($article->image_couverture) }}">
  @endif
@endsection

@section('content')
<section class="section" style="padding-top:90px;min-height:80vh;">

  {{-- Image couverture pleine largeur --}}
  @if($article->image_couverture)
  <div style="width:100%;height:380px;overflow:hidden;margin-bottom:0;">
    <img src="{{ asset($article->image_couverture) }}" alt="{{ $article->titre }}" style="width:100%;height:100%;object-fit:cover;">
  </div>
  @endif

  <div class="container" style="max-width:860px;margin-top:40px;">

    {{-- Catégorie + méta --}}
    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
      <span style="background:{{ $article->categorie_couleur }};color:#fff;font-size:11px;font-weight:700;padding:4px 14px;border-radius:20px;">
        {{ $article->categorie_libelle }}
      </span>
      <span style="font-size:12px;color:#aaa;">{{ $article->created_at->format('d F Y') }}</span>
      <span style="font-size:12px;color:#aaa;">· ✍️ {{ $article->auteur?->name ?? 'Teranga Immobilier' }}</span>
      <span style="font-size:12px;color:#aaa;">· 👁 {{ number_format($article->vues) }} vues</span>
    </div>

    {{-- Titre --}}
    <h1 class="fw-bold mb-4" style="font-size:clamp(22px,4vw,34px);line-height:1.3;color:#0d1c2e;">{{ $article->titre }}</h1>

    {{-- Contenu --}}
    <div style="font-size:15px;line-height:1.85;color:#333;">
      {!! nl2br(e($article->contenu)) !!}
    </div>

    {{-- Partage --}}
    <div class="mt-5 pt-4" style="border-top:2px solid #f0f0f0;">
      <div class="fw-bold mb-3" style="font-size:14px;">Partager cet article :</div>
      <div class="d-flex gap-2 flex-wrap">
        @php $url = urlencode(request()->fullUrl()); $titre = urlencode($article->titre); @endphp
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank" rel="noopener"
           style="background:#1877f2;color:#fff;border-radius:8px;padding:8px 18px;font-size:12px;font-weight:700;text-decoration:none;">
          f Facebook
        </a>
        <a href="https://wa.me/?text={{ $titre }}%20{{ $url }}" target="_blank" rel="noopener"
           style="background:#25d366;color:#fff;border-radius:8px;padding:8px 18px;font-size:12px;font-weight:700;text-decoration:none;">
          💬 WhatsApp
        </a>
        <a href="https://twitter.com/intent/tweet?text={{ $titre }}&url={{ $url }}" target="_blank" rel="noopener"
           style="background:#1da1f2;color:#fff;border-radius:8px;padding:8px 18px;font-size:12px;font-weight:700;text-decoration:none;">
          𝕏 Twitter
        </a>
        <a href="{{ route('blog.index') }}" style="background:#f0f4f8;color:#0d1c2e;border-radius:8px;padding:8px 18px;font-size:12px;font-weight:600;text-decoration:none;">
          ← Retour au blog
        </a>
      </div>
    </div>

    {{-- Articles similaires --}}
    @if($similaires->isNotEmpty())
    <div class="mt-5 pt-4" style="border-top:2px solid #f0f0f0;">
      <h5 class="fw-bold mb-4">📚 Articles similaires</h5>
      <div class="row g-3">
        @foreach($similaires as $sim)
        <div class="col-md-4">
          <a href="{{ route('blog.show', $sim->slug) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100" style="border-radius:12px;overflow:hidden;">
              @if($sim->image_couverture)
                <img src="{{ asset($sim->image_couverture) }}" style="height:130px;width:100%;object-fit:cover;">
              @else
                <div style="height:80px;background:#f0f4f8;display:flex;align-items:center;justify-content:center;font-size:32px;">📰</div>
              @endif
              <div class="p-3">
                <p class="fw-bold text-dark mb-1" style="font-size:13px;line-height:1.4;">{{ \Str::limit($sim->titre, 70) }}</p>
                <span style="font-size:10px;color:#aaa;">{{ $sim->created_at->format('d/m/Y') }}</span>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
    @endif

  </div>
</section>
@endsection
