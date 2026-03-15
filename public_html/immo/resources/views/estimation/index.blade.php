@extends('layouts.accueil')

@section('title', 'Estimation de bien immobilier — ' . config('app.name'))

@section('content')
<section class="section mt-4" style="min-height: 80vh;">
  <div class="container" style="margin-top: 100px;">

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h4 class="mb-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 3L2 12h3v9h6v-5h2v5h6v-9h3zm0 2.7L19 12v7h-4v-5H9v5H5v-7z"/></svg>
          Estimation de votre bien
        </h4>
        <p class="text-muted mb-4" style="font-size:13px;">Obtenez une estimation de la valeur de votre bien basée sur les annonces du marché.</p>

        <div class="card border-0 shadow-sm p-4 mb-4">
          <form method="POST" action="{{ route('estimation.estimer') }}">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold" style="font-size:13px;">Type de bien *</label>
                <select name="type_bien" class="form-control" required>
                  <option value="">— Choisir —</option>
                  <option value="appartement" {{ old('type_bien', request('type_bien')) == 'appartement' ? 'selected' : '' }}>Appartement</option>
                  <option value="maison" {{ old('type_bien', request('type_bien')) == 'maison' ? 'selected' : '' }}>Maison / Villa</option>
                  <option value="terrain" {{ old('type_bien', request('type_bien')) == 'terrain' ? 'selected' : '' }}>Terrain</option>
                  <option value="bureau" {{ old('type_bien', request('type_bien')) == 'bureau' ? 'selected' : '' }}>Bureau / Local</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold" style="font-size:13px;">Surface (m²) *</label>
                <input type="number" name="surface" class="form-control" min="10" value="{{ old('surface', request('surface')) }}" placeholder="Ex: 120" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold" style="font-size:13px;">Commune</label>
                <select name="commune_id" class="form-control select2">
                  <option value="">— Toutes communes —</option>
                  @foreach($communes as $commune)
                    <option value="{{ $commune->id }}" {{ old('commune_id') == $commune->id ? 'selected' : '' }}>{{ $commune->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label fw-bold" style="font-size:13px;">Chambres</label>
                <input type="number" name="chambres" class="form-control" min="0" max="20" value="{{ old('chambres', 3) }}" placeholder="Ex: 3">
              </div>
              <div class="col-md-3">
                <label class="form-label fw-bold" style="font-size:13px;">État du bien</label>
                <select name="etat" class="form-control">
                  <option value="neuf">Neuf</option>
                  <option value="recent">Récent (&lt; 5 ans)</option>
                  <option value="bon" selected>Bon état</option>
                  <option value="a_renover">À rénover</option>
                </select>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5A6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5S14 7.01 14 9.5S11.99 14 9.5 14"/></svg>
                  Estimer mon bien
                </button>
              </div>
            </div>
          </form>
        </div>

        {{-- Résultat --}}
        @isset($result)
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-left:4px solid #27E3C0 !important;">
          <h6 class="mb-3">Résultat de l'estimation</h6>
          <p class="text-muted mb-3" style="font-size:12px;">
            Basé sur {{ $result['nb_annonces'] }} annonce(s) du marché.
            Prix moyen au m² : {{ number_format($result['prix_m2'], 0, ',', ' ') }} CFA/m²
          </p>
          <div class="row g-3 text-center mb-3">
            <div class="col-4">
              <div class="rounded p-3" style="background:#f8f9fa;">
                <div style="font-size:10px;color:#888;margin-bottom:4px;">MINIMUM</div>
                <div style="font-size:16px;font-weight:700;color:#6c757d;">{{ number_format($result['prix_min'], 0, ',', ' ') }}</div>
                <div style="font-size:10px;color:#aaa;">CFA</div>
              </div>
            </div>
            <div class="col-4">
              <div class="rounded p-3" style="background:#0d1c2e;color:#fff;">
                <div style="font-size:10px;opacity:.7;margin-bottom:4px;">ESTIMATION</div>
                <div style="font-size:20px;font-weight:700;color:#27E3C0;">{{ number_format($result['prix_estime'], 0, ',', ' ') }}</div>
                <div style="font-size:10px;opacity:.6;">CFA</div>
              </div>
            </div>
            <div class="col-4">
              <div class="rounded p-3" style="background:#f8f9fa;">
                <div style="font-size:10px;color:#888;margin-bottom:4px;">MAXIMUM</div>
                <div style="font-size:16px;font-weight:700;color:#6c757d;">{{ number_format($result['prix_max'], 0, ',', ' ') }}</div>
                <div style="font-size:10px;color:#aaa;">CFA</div>
              </div>
            </div>
          </div>
          <p class="text-muted" style="font-size:11px;">⚠️ Cette estimation est indicative et basée sur les prix du marché. Pour une évaluation précise, consultez un agent immobilier.</p>
        </div>

        @if(isset($similaires) && $similaires->isNotEmpty())
        <div class="mb-4">
          <h6 class="mb-3">Annonces similaires</h6>
          <div class="row g-3">
            @foreach($similaires as $annonce)
              <div class="col-md-4">
                <a href="{{ route('annonce', $annonce->slug) }}" class="text-decoration-none text-dark">
                  <div class="card border-0 shadow-sm h-100">
                    @if($annonce->images->isNotEmpty())
                      <img src="{{ asset($annonce->images->first()->url) }}" class="card-img-top" style="height:130px;object-fit:cover;" alt="">
                    @endif
                    <div class="card-body p-2">
                      <div class="fw-bold" style="font-size:13px;">{{ number_format($annonce->prix, 0, ',', ' ') }} CFA</div>
                      <div style="font-size:11px;color:#888;">{{ $annonce->commune?->name ?? '' }}</div>
                      @if($annonce->surface)
                        <div style="font-size:11px;color:#888;">{{ $annonce->surface }} m²</div>
                      @endif
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div>
        @endif
        @endisset

      </div>
    </div>

  </div>
</section>
@endsection
