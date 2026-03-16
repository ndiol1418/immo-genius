@php
    // Fallback : si $recommandations n'est pas fourni par le contrôleur,
    // on charge 4 annonces aléatoires directement depuis la BD
    if (!isset($recommandations) || $recommandations->isEmpty()) {
        $recommandations = \App\Models\Annonce::withoutGlobalScope(\App\Scopes\AnnonceScope::class)
            ->with('images')
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }
@endphp

@if($recommandations->isNotEmpty())
<section class="py-4" style="background:#f9fbe7;">
  <div class="container">
    <div class="d-flex align-items-center gap-2 mb-3">
      <span style="font-size:22px;">🤖</span>
      <div>
        <h5 class="mb-0 fw-bold" style="color:#0d1c2e;">Recommandé pour vous</h5>
        <p class="mb-0" style="font-size:12px;color:#888;">
          @auth Sélectionné selon votre historique @else Sélectionné pour vous @endauth
        </p>
      </div>
    </div>
    <div class="row g-3">
      @foreach($recommandations as $reco)
        @php $img = $reco->images->first(); @endphp
        <div class="col-6 col-md-3">
          <a href="{{ route('annonce', $reco->slug) }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm" style="border-radius:12px;overflow:hidden;transition:transform .2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
              <div style="position:relative;height:140px;overflow:hidden;">
                <img src="{{ $img ? asset($img->url) : asset('img/logo-teranga.png') }}" alt="{{ $reco->name }}" style="width:100%;height:100%;object-fit:cover;">
                <span style="position:absolute;top:6px;left:6px;background:#2E7D32;color:#0d1c2e;font-size:9px;font-weight:700;padding:2px 8px;border-radius:10px;">🤖 Recommandé</span>
              </div>
              <div class="card-body p-2">
                <p class="mb-1 fw-bold" style="font-size:12px;color:#0d1c2e;line-height:1.3;">{{ \Str::limit($reco->name, 30) }}</p>
                <p class="mb-1" style="font-size:13px;color:#2E7D32;font-weight:700;">{{ number_format($reco->prix, 0, ',', ' ') }} CFA</p>
                <div class="d-flex gap-2" style="font-size:10px;color:#888;">
                  @if($reco->superficie)<span>📐 {{ $reco->superficie }}m²</span>@endif
                  @if($reco->chambres)<span>🛏 {{ $reco->chambres }}</span>@endif
                </div>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif
