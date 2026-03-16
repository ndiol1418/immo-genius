@extends('layouts.accueil')

@section('title', 'Estimation IA — ' . config('app.name'))

@section('content')
<section class="section" style="min-height:80vh;padding-top:120px;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9">

        {{-- En-tête --}}
        <div class="d-flex align-items-center gap-3 mb-4">
          <div style="width:52px;height:52px;background:#2E7D32;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:26px;">🏠</div>
          <div>
            <h4 class="mb-0 fw-bold">Zestimate Teranga — Estimation IA</h4>
            <p class="mb-0 text-muted" style="font-size:13px;">Estimation intelligente basée sur les prix du marché immobilier sénégalais</p>
          </div>
        </div>

        {{-- Formulaire --}}
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px;">
          <form method="POST" action="{{ route('estimation.estimer') }}">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold" style="font-size:13px;">Type de bien *</label>
                <select name="type_bien" class="form-control" required>
                  <option value="">— Choisir —</option>
                  <option value="appartement" @if(old('type_bien')=='appartement') selected @endif>Appartement</option>
                  <option value="maison"       @if(old('type_bien')=='maison') selected @endif>Maison / Villa</option>
                  <option value="terrain"      @if(old('type_bien')=='terrain') selected @endif>Terrain</option>
                  <option value="bureau"       @if(old('type_bien')=='bureau') selected @endif>Bureau / Local</option>
                  <option value="duplex"       @if(old('type_bien')=='duplex') selected @endif>Duplex</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold" style="font-size:13px;">Surface (m²) *</label>
                <input type="number" name="surface" class="form-control" min="10"
                  value="{{ old('surface') }}" placeholder="Ex: 120" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold" style="font-size:13px;">Commune / Quartier</label>
                <select name="commune_id" class="form-control select2">
                  <option value="">— Toutes communes —</option>
                  @foreach($communes as $commune)
                    <option value="{{ $commune->id }}" @if(old('commune_id')==$commune->id) selected @endif>{{ $commune->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <label class="form-label fw-bold" style="font-size:13px;">Chambres</label>
                <input type="number" name="chambres" class="form-control" min="0" max="20"
                  value="{{ old('chambres', 3) }}" placeholder="3">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold" style="font-size:13px;">État du bien</label>
                <select name="etat" class="form-control">
                  <option value="neuf"      @if(old('etat')=='neuf') selected @endif>Neuf (+30%)</option>
                  <option value="recent"    @if(old('etat')=='recent') selected @endif>Récent &lt; 5 ans (+10%)</option>
                  <option value="bon"       @if(old('etat','bon')=='bon') selected @endif>Bon état</option>
                  <option value="a_renover" @if(old('etat')=='a_renover') selected @endif>À rénover (-25%)</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold" style="font-size:13px;">Mobilier</label>
                <select name="meuble" class="form-control">
                  <option value="non_meuble" @if(old('meuble','non_meuble')=='non_meuble') selected @endif>Non meublé</option>
                  <option value="meuble"     @if(old('meuble')=='meuble') selected @endif>Meublé (+15%)</option>
                </select>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-lg px-5"
                  style="background:#2E7D32;color:#fff;border-radius:10px;font-weight:600;">
                  🤖 Estimer mon bien
                </button>
              </div>
            </div>
          </form>
        </div>

        {{-- Résultat --}}
        @isset($result)

        @if(isset($estimationsSemaine) && $estimationsSemaine > 0)
        <div class="mb-3 text-center p-2 rounded-3" style="background:#f1f8e9;font-size:13px;color:#2E7D32;">
          📊 <strong>{{ $estimationsSemaine }}</strong> estimation(s) faite(s) cette semaine dans la zone <strong>{{ $result['commune_name'] }}</strong>
        </div>
        @endif

        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px;border-left:5px solid #2E7D32 !important;">

          <h6 class="fw-bold mb-1">Résultat de l'estimation</h6>
          <p class="text-muted mb-3" style="font-size:12px;">
            Basé sur <strong>{{ $result['nb_annonces'] }}</strong> annonce(s) —
            Prix/m² moyen : <strong>{{ number_format($result['prix_m2'], 0, ',', ' ') }} CFA/m²</strong>
          </p>

          {{-- Fourchette --}}
          <div class="row g-3 text-center mb-3">
            <div class="col-4">
              <div class="rounded-3 p-3" style="background:#f8f9fa;">
                <div style="font-size:10px;color:#888;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Minimum</div>
                <div style="font-size:15px;font-weight:700;color:#6c757d;">{{ number_format($result['prix_min'], 0, ',', ' ') }}</div>
                <div style="font-size:10px;color:#aaa;">CFA</div>
              </div>
            </div>
            <div class="col-4">
              <div class="rounded-3 p-3" style="background:#0d1c2e;color:#fff;transform:scale(1.05);box-shadow:0 6px 24px rgba(0,0,0,.25);">
                <div style="font-size:10px;opacity:.7;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Estimation IA</div>
                <div style="font-size:22px;font-weight:800;color:#4CAF50;">{{ number_format($result['prix_estime'], 0, ',', ' ') }}</div>
                <div style="font-size:10px;opacity:.6;">CFA</div>
              </div>
            </div>
            <div class="col-4">
              <div class="rounded-3 p-3" style="background:#f8f9fa;">
                <div style="font-size:10px;color:#888;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Maximum</div>
                <div style="font-size:15px;font-weight:700;color:#6c757d;">{{ number_format($result['prix_max'], 0, ',', ' ') }}</div>
                <div style="font-size:10px;color:#aaa;">CFA</div>
              </div>
            </div>
          </div>

          {{-- Barre de progression --}}
          <div class="mb-4 px-1">
            <div style="position:relative;height:10px;background:#e9ecef;border-radius:10px;overflow:visible;">
              <div style="height:100%;width:100%;background:linear-gradient(to right,#ccc,#2E7D32,#ccc);border-radius:10px;"></div>
              <div style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);width:18px;height:18px;background:#fff;border:3px solid #2E7D32;border-radius:50%;box-shadow:0 2px 6px rgba(0,0,0,.2);"></div>
            </div>
            <div class="d-flex justify-content-between mt-1" style="font-size:10px;color:#aaa;">
              <span>{{ number_format($result['prix_min'], 0, ',', ' ') }} CFA</span>
              <span>{{ number_format($result['prix_max'], 0, ',', ' ') }} CFA</span>
            </div>
          </div>

          {{-- Niveau de confiance --}}
          <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3" style="background:#f8f9fa;">
            <div style="min-width:90px;">
              <div style="font-size:10px;color:#888;margin-bottom:2px;">Niveau de confiance</div>
              <div class="fw-bold" style="color:{{ $result['confiance_color'] }};font-size:17px;">
                {{ $result['confiance'] }}
              </div>
            </div>
            <div class="flex-grow-1">
              <div style="height:8px;background:#e9ecef;border-radius:8px;overflow:hidden;">
                <div style="height:100%;width:{{ $result['confiance_pct'] }}%;background:{{ $result['confiance_color'] }};border-radius:8px;"></div>
              </div>
              <div style="font-size:10px;color:#aaa;margin-top:3px;">
                @if($result['confiance'] == 'Élevé') Données de marché abondantes
                @elseif($result['confiance'] == 'Moyen') Quelques références disponibles
                @else Peu de données dans cette zone
                @endif
                — {{ $result['nb_annonces'] }} annonce(s) analysée(s)
              </div>
            </div>
          </div>

          {{-- Détail coefficients (collapsable) --}}
          <div>
            <button class="btn btn-sm p-0 text-decoration-none" style="font-size:12px;color:#2E7D32;background:none;border:none;"
              onclick="var el=document.getElementById('detailCoeffs');el.style.display=el.style.display==='none'?'block':'none'">
              🔍 Voir le détail des coefficients appliqués ▾
            </button>
            <div id="detailCoeffs" style="display:none;margin-top:8px;">
              <table class="table table-sm mb-0" style="font-size:12px;">
                <tbody>
                  @foreach($result['detail'] as $row)
                  <tr>
                    <td class="text-muted border-0">{{ $row['label'] }}</td>
                    <td class="fw-bold text-end border-0"
                      style="color:{{ str_starts_with($row['valeur'],'+') ? '#2E7D32' : (str_starts_with($row['valeur'],'-') ? '#dc3545' : '#333') }}">
                      {{ $row['valeur'] }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <hr class="my-3">
          <p class="text-muted mb-0" style="font-size:11px;">⚠️ Estimation indicative basée sur les données du marché. Consultez un agent Teranga pour une évaluation précise.</p>
        </div>

        {{-- 3 annonces similaires --}}
        @if(isset($similaires) && $similaires->isNotEmpty())
        <h6 class="fw-bold mb-3">📍 Annonces similaires sur le marché</h6>
        <div class="row g-3 mb-5">
          @foreach($similaires as $annonce)
          <div class="col-md-4">
            <a href="{{ route('annonce', $annonce->slug) }}" class="text-decoration-none text-dark">
              <div class="card border-0 shadow-sm h-100" style="border-radius:12px;overflow:hidden;transition:transform .2s;"
                onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                @php $img = $annonce->images->first(); @endphp
                <div style="height:130px;overflow:hidden;">
                  <img src="{{ $img ? asset($img->url) : asset('img/logo-teranga.png') }}"
                    style="width:100%;height:100%;object-fit:cover;" alt="{{ $annonce->slug }}">
                </div>
                <div class="card-body p-2">
                  <div class="fw-bold" style="font-size:14px;color:#2E7D32;">
                    {{ number_format($annonce->prix, 0, ',', ' ') }} CFA
                  </div>
                  <div style="font-size:11px;color:#888;">📍 {{ $annonce->commune?->name ?? '' }}</div>
                  @if($annonce->surface)
                  <div style="font-size:11px;color:#888;">
                    📐 {{ $annonce->surface }} m²
                    &nbsp;·&nbsp; {{ number_format($annonce->prix / $annonce->surface, 0, ',', ' ') }} CFA/m²
                  </div>
                  @endif
                </div>
              </div>
            </a>
          </div>
          @endforeach
        </div>
        @endif

        @endisset

      </div>
    </div>
  </div>
</section>
@endsection
