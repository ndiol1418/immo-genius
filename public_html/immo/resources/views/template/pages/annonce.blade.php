@extends('layouts.accueil')
<link href="{{ asset('css/marker.css') }}" rel="stylesheet">
@php
    $mainImage   = $annonce->images && count($annonce->images) ? asset($annonce->images[0]->url) : '';
    $typeLocation = $annonce->type_location_id == 1 ? 'à vendre' : 'à louer';
    $commune      = $annonce->commune?->name ?? '';
    $typeImmo     = $annonce->type_immo?->name ?? 'bien immobilier';
    $descSeo      = Str::limit(strip_tags($annonce->description ?? ''), 155) ?: "{$typeImmo} {$typeLocation} à {$commune} — {$annonce->adresse}. Prix : " . number_format($annonce->prix, 0, '', ' ') . ' CFA.';
    $keywordsSeo  = implode(', ', array_filter([
        $annonce->name,
        $typeImmo,
        $typeLocation,
        $commune,
        $annonce->adresse,
        'immobilier Sénégal',
        'annonce immobilière',
        config('app.name'),
    ]));
    $canonicalUrl = $url ?? request()->fullUrl();
@endphp

@section('title', $annonce->name . ' — ' . ucfirst($typeImmo) . ' ' . $typeLocation . ($commune ? ' à ' . $commune : '') . ' | ' . config('app.name'))

@section('meta')
    {{-- Description & Keywords --}}
    <meta name="description" content="{{ $descSeo }}">
    <meta name="keywords" content="{{ $keywordsSeo }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="article">
    <meta property="og:site_name"   content="{{ config('app.name') }}">
    <meta property="og:url"         content="{{ $canonicalUrl }}">
    <meta property="og:title"       content="{{ $annonce->name }} — {{ ucfirst($typeImmo) }} {{ $typeLocation }}{{ $commune ? ' à ' . $commune : '' }}">
    <meta property="og:description" content="{{ $descSeo }}">
    @if($mainImage)
    <meta property="og:image"       content="{{ $mainImage }}">
    <meta property="og:image:alt"   content="{{ $annonce->name }}">
    @endif
    <meta property="og:locale"      content="fr_SN">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $annonce->name }} — {{ ucfirst($typeImmo) }} {{ $typeLocation }}{{ $commune ? ' à ' . $commune : '' }}">
    <meta name="twitter:description" content="{{ $descSeo }}">
    @if($mainImage)
    <meta name="twitter:image"       content="{{ $mainImage }}">
    @endif

    {{-- Schema.org RealEstateListing --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "RealEstateListing",
        "name": "{{ addslashes($annonce->name) }}",
        "description": "{{ addslashes($descSeo) }}",
        "url": "{{ $canonicalUrl }}",
        @if($mainImage)"image": "{{ $mainImage }}",@endif
        "offers": {
            "@type": "Offer",
            "price": "{{ $annonce->prix }}",
            "priceCurrency": "XOF"
        }
        @if($commune),"address": {"@type": "PostalAddress", "addressLocality": "{{ $commune }}", "addressCountry": "SN"}@endif
    }
    </script>
@endsection

<style>
  #map { height: 500px !important}
  td{font-size: 12px}
  .icon-card{border-radius: 50px;
    border: 1px solid #26e3c0;
    padding: 2px;
    background: #26e3c0;}
</style>
@section('content')

  
      <!-- Services Section -->
    <section id="services" class="services section mt-4">
  
        <!-- Section Title -->
        {{-- <div class="container" style="margin-top:100px;">
        </div> --}}
        <div class="container section-title mt-4" data-aos="fade-up">
          <div class="row">
            <div class="col-lg-6 mb-2">
              <div class="img_annonce" style="height: 300px !important">
                <img src="{{ asset($annonce->images&&count($annonce->images)?$annonce->images[0]->url:'') }}" alt="" width="100%" style="height: 300px;object-fit:cover;border-radius: 5px;">
                @if(!empty($annonce->visite_virtuelle_type) && $annonce->visite_virtuelle_type !== 'none')
                  <button type="button"
                    onclick="document.getElementById('modalVisiteVirtuelle').style.display='flex'"
                    style="position:absolute;left:10px;bottom:10px;background:#27E3C0;color:#fff;border:none;
                           border-radius:20px;padding:6px 14px;font-size:12px;font-weight:bold;cursor:pointer;
                           display:flex;align-items:center;gap:6px;z-index:5;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10.55 2.876L4.595 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l5.957-3.306a2.98 2.98 0 0 0 1.529-2.611V8.793a2.98 2.98 0 0 0-1.529-2.61L13.45 2.876a2.98 2.98 0 0 0-2.898 0Z"/><path d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12"/></g></svg>
                    Visite Virtuelle 🏠
                  </button>
                @endif
              </div>
            </div>
            <div class="col-lg-6">
              <div class="row" style="position: relative">
                @foreach($annonce->images as $key => $image)
                  <div class="col-6 col-lg-6 mb-2 image-item {{ $key >= 4 ? 'd-none extra-image' : '' }}">
                    <img src="{{ asset($image->url) }}" alt="" width="100%" style="height: 150px; object-fit: cover; border-radius: 5px;">
                  </div>
                @endforeach
            
                @if($annonce->images->count() > 4)
                  <div class="col-12 mt-2" style="position: absolute;bottom: 15px;left: -8px;text-align: right;">
                    <button id="voirPlusBtn" class="btn btn-light btn-sm text-sm" style="border-radius: 30px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M18 4.25H6A2.75 2.75 0 0 0 3.25 7v10A2.75 2.75 0 0 0 6 19.75h12A2.75 2.75 0 0 0 20.75 17V7A2.75 2.75 0 0 0 18 4.25M6 5.75h12A1.25 1.25 0 0 1 19.25 7v8.19l-2.72-2.72a.7.7 0 0 0-.56-.22a.8.8 0 0 0-.55.27l-1.29 1.55l-4.6-4.6A.7.7 0 0 0 9 9.25a.8.8 0 0 0-.55.27l-3.7 4.41V7A1.25 1.25 0 0 1 6 5.75M4.75 17v-.73l4.3-5.16l4.12 4.12l-2.52 3H6A1.25 1.25 0 0 1 4.75 17M18 18.25h-5.4l3.45-4.14l3.15 3.15a1.23 1.23 0 0 1-1.2.99"/></svg>
                      Tout Voir
                    </button>
                  </div>
                @endif
              </div>
            </div>
            
            <script>
              document.addEventListener('DOMContentLoaded', function () {
                const btn = document.getElementById('voirPlusBtn');
                if (btn) {
                  btn.addEventListener('click', function () {
                    document.querySelectorAll('.extra-image').forEach(el => el.classList.remove('d-none'));
                    btn.remove(); // On supprime le bouton après affichage
                  });
                }
              });
            </script>
            

          </div>


       
          <div class="row d-flex justify-content-between mt-4">
            <div class="col-lg-6 col-12">
              <div class="d-flex justify-content-between">
                <div>
                  <span class="text-capitalize h4">{{ $annonce->name }}</span>

                  <p style="font-size: 12px;align-items: center;display: flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4s-4 1.794-4 4s1.794 4 4 4m0-6c1.103 0 2 .897 2 2s-.897 2-2 2s-2-.897-2-2s.897-2 2-2"/><path fill="currentColor" d="M11.42 21.814a1 1 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819M12 4c3.309 0 6 2.691 6 6.005c.021 4.438-4.388 8.423-6 9.73c-1.611-1.308-6.021-5.294-6-9.735c0-3.309 2.691-6 6-6"/></svg>
                    {{ $annonce->adresse }}
                  </p>
                  <p>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}&quote={{ urlencode($annonce->name) }}"
                      target="_blank" rel="noopener noreferrer"
                      class="btn btn-primary btn-sm">
                      Partager sur Facebook
                   </a>
                  </p>
                </div>
                <span style="font-size: 18px">{{ number_format($annonce->prix,0,'',' ') }} CFA</span>
              </div>
              <div class="row">
                <div class="col-12" style="margin-top: 30px">
                  <h4>Informations Générales</h4>
                </div>
                <div class="col-lg-12">
                  <div class="row">
                    @include('template.pages.partials.infos')
                  </div>
                </div>
                <div class="col-12" style="margin-top: 30px">
                  <h5>Description</h5>
                  {!! $annonce->description !!}
                </div>
                <div class="col-12" style="margin-top: 30px">
                  <h5>Comodites</h5>
                  @if($annonce->liste_comodites() && count($annonce->liste_comodites()))
                  <p class="mb-0"> <strong>Interieures</strong></p>
                  <ul class="list-group p-4">
                    @foreach ($annonce->liste_comodites_internes() as $comodite)
                      <li>{{ $comodite->name }}</li>
                    @endforeach
                  </ul>
                  <p class="mb-0"> <strong>Exterieures</strong></p>
                  <ul class="list-group p-4">
                    @foreach ($annonce->liste_comodites_externes() as $comodite)
                      <li>{{ $comodite->name }}</li>
                    @endforeach
                  </ul>
                  @else
                    <div class="jumbotron bg-light p-4">
                      <p class="text-center">Aucune données</p>
                    </div>
                  @endif
                </div>
                <div class="col-12" style="margin-top: 30px">
                  <h5>Localisation</h5>
                  <div id="map"></div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-12">
              @include('template.components.premium-agent',['tel'=>$annonce->immo->fournisseur?$annonce->immo->fournisseur->telephone:env('tel'),
              'nom_complet'=>$annonce->immo->fournisseur?$annonce->immo->fournisseur->nom_complet:'---','agent_id'=>$annonce->immo->fournisseur?$annonce->immo->fournisseur->id:null])
            </div>
          </div>

        </div><!-- End Section Title -->

        {{-- Bouton favori --}}
        @php $isFavori = auth()->check() ? \App\Models\Favori::where('user_id', auth()->id())->where('annonce_id', $annonce->id)->exists() : false; @endphp
        <div class="container mb-2">
          <button onclick="toggleFavoriDetail({{ $annonce->id }}, this)"
            id="btnFavoriDetail"
            data-favori="{{ $isFavori ? '1' : '0' }}"
            style="background:{{ $isFavori ? '#e74c3c' : '#fff' }};border:2px solid {{ $isFavori ? '#e74c3c' : '#ddd' }};border-radius:30px;padding:8px 20px;cursor:pointer;display:inline-flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:{{ $isFavori ? '#fff' : '#333' }};">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
              fill="{{ $isFavori ? '#fff' : 'none' }}" stroke="{{ $isFavori ? '#fff' : '#e74c3c' }}" stroke-width="2">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54z"/>
            </svg>
            <span id="favoriLabel">{{ $isFavori ? 'Retiré des favoris' : 'Ajouter aux favoris' }}</span>
          </button>
        </div>

        {{-- Modal Contact Agent --}}
        <div id="modalContactAgent" style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,.55);align-items:center;justify-content:center;">
          <div style="background:#fff;border-radius:16px;padding:28px 30px;width:90%;max-width:480px;position:relative;">
            <button onclick="document.getElementById('modalContactAgent').style.display='none'"
              style="position:absolute;top:14px;right:16px;background:none;border:none;font-size:22px;cursor:pointer;color:#999;">&times;</button>
            <h5 style="margin:0 0 6px;color:#061630;">Contacter l'agent</h5>
            <p style="font-size:12px;color:#888;margin-bottom:16px;">{{ $annonce->name }}</p>
            @if(auth()->check())
              <form method="POST" action="{{ route('messages.contact', $annonce->id) }}">
                @csrf
                <textarea name="contenu" rows="4" required placeholder="Bonjour, je suis intéressé par cette annonce..."
                  style="width:100%;border:1px solid #ddd;border-radius:10px;padding:12px;font-size:13px;resize:none;outline:none;"></textarea>
                <button type="submit" style="margin-top:12px;width:100%;background:#27E3C0;color:#fff;border:none;border-radius:10px;padding:12px;font-size:14px;font-weight:bold;cursor:pointer;">
                  Envoyer le message
                </button>
              </form>
            @else
              <p style="text-align:center;color:#555;font-size:13px;">Vous devez être connecté pour envoyer un message.</p>
              <a href="{{ route('login') }}" style="display:block;text-align:center;background:#27E3C0;color:#fff;padding:12px;border-radius:10px;text-decoration:none;font-weight:bold;">Se connecter</a>
            @endif
          </div>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-12">
              <div class="row">
                <div class="col-12" style="margin-top: 30px">
                  <h5>Propriétés similaires</h5>
                  <div class="row">
                    @include('template.pages.component-annonces',[
                      'col'=>'col-lg-3 col-12 col-sm-4',
                      'annonces'=>$annonces
                    ])
                  </div>
               {{-- @include('template.pages.component-annonces') --}}
              </div>
            </div>
          </div>
      </div>
  
    </section><!-- /Services Section -->
  
@endsection

  {{-- <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
        document.getElementById("demo-form").submit();
        }
    </script>
    <script>
        $(function() {
            $("#password").on('change keyup', function(e) {
                var sanitizePassword = $(this).val().trim();
                $(this).val(sanitizePassword);
            });
        });

        var onloadCallback = function() {
            alert("grecaptcha is ready!");
        };
    </script> --}}

<style>
    footer{
        height: 24px !important;
        position: fixed;
        width: 100%;
        bottom: 0;
        background-color: #f8f9fa;
    }
</style>

<script>
function toggleFavoriDetail(annonceId, btn) {
    @if(!auth()->check())
        window.location.href = '{{ route("login") }}';
        return;
    @endif
    fetch('{{ url("/favoris/toggle") }}/' + annonceId, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        const svg = btn.querySelector('svg');
        const label = document.getElementById('favoriLabel');
        if (data.status === 'added') {
            btn.style.background = '#e74c3c'; btn.style.borderColor = '#e74c3c'; btn.style.color = '#fff';
            svg.setAttribute('fill','#fff'); svg.setAttribute('stroke','#fff');
            label.textContent = 'Retiré des favoris';
        } else {
            btn.style.background = '#fff'; btn.style.borderColor = '#ddd'; btn.style.color = '#333';
            svg.setAttribute('fill','none'); svg.setAttribute('stroke','#e74c3c');
            label.textContent = 'Ajouter aux favoris';
        }
    });
}
document.addEventListener('keydown', e => { if(e.key==='Escape') document.getElementById('modalContactAgent').style.display='none'; });
</script>

@section('scriptBottom')
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.0/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.0/mapbox-gl.css" rel="stylesheet">
<script>
  mapboxgl.accessToken = '{{ config("services.mapbox.token") }}';

  const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-17.4467, 14.6928], // Dakar
    zoom: 10,
    attributionControl: false
  });
  // const locations = [
  //   {
  //     coords: [-16.785, 14.436],
  //     price: '200k',
  //     image: 'http://127.0.0.1:8000/uploads/annonces/O6imupload.jpg',
  //     city: 'Saly, Thiès',
  //     priceText: '200.000 FR'
  //   },
  //   {
  //     coords: [-17.0, 14.8],
  //     price: '145k',
  //     image: 'http://127.0.0.1:8000/uploads/annonces/O6imupload.jpg',
  //     city: 'Ngaparou, Thiès',
  //     priceText: '145.000 FR'
  //   }
  // ];
  const element = @json($annonce);
  const array = [];

  var item = element.immo;
  // var url = '' 

  if (element.immo && item.lon!== null && item.lat!== null) {   
    // console.log(element);
    
    array.push({
      coords: [
          element.lon !== undefined ? parseFloat(element.lon) : 0,
          element.lat !== undefined ? parseFloat(element.lat) : 0
      ],
      price: kConverter(element.prix),
      image: element.images?.[0]?.url ?? '',
      city: element.commune 
          ? `${element.adresse ?? '---'}, ${element.commune.name}, ${element.commune.departement?.name ?? ''}` 
          : (element.adresse ?? '---'),
      priceText: `${element.prix} CFA`
  });

      // coords = [parseInt(item.lon), parseInt(item.lat)]
  }
  
  array.forEach(loc => {
    
    const el = document.createElement('div');
    el.className = 'price-marker';
    el.textContent = loc.price;

    const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
      // `<strong>${loc.city}</strong><br>${loc.city}`
      `<div class="custom-popup">
          <img src="${asset(loc.image)}" alt="photo">
          <h4>${loc.priceText}</h4>
          <p><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4s-4 1.794-4 4s1.794 4 4 4m0-6c1.103 0 2 .897 2 2s-.897 2-2 2s-2-.897-2-2s.897-2 2-2"/><path fill="currentColor" d="M11.42 21.814a1 1 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819M12 4c3.309 0 6 2.691 6 6.005c.021 4.438-4.388 8.423-6 9.73c-1.611-1.308-6.021-5.294-6-9.735c0-3.309 2.691-6 6-6"/></svg> ${loc.city}</p>
        </div>`
    );

    const marker = new mapboxgl.Marker(el)
      .setLngLat(loc.coords)
      .setPopup(popup)
      .addTo(map);

    map.flyTo({ center: [element.lon, element.lat], zoom: 13 });
    marker.setLngLat([element.lon, element.lat]).addTo(map);
    // const marker = new mapboxgl.Marker(el)
    //   .setLngLat(loc.coords)
    //   .addTo(map);

    // Au clic : on affiche un popup personnalisé
    // marker.getElement().addEventListener('click', () => {
    //   const popupHTML = `
    //     <div class="custom-popup">
    //       <img src="${loc.image}" alt="photo">
    //       <h4>${loc.priceText}</h4>
    //       <p>📍 ${loc.city}</p>
    //     </div>
    //   `;

    //   new mapboxgl.Popup({ offset: 30 })
    //     .setLngLat(loc.coords)
    //     // .setHTML(popupHTML)
    //     .addTo(map);
    // });
  });

  function asset(path) {
    return `${window.location.origin}/${path.replace(/^\/+/, '')}`;
  }
  function kConverter(num) {
        return num <= 999 ? num : (0.1 * Math.floor(num / 100)).toFixed(1).replace('.0','') + 'k';
    }
</script>

@php
    $vvType   = $annonce->visite_virtuelle_type ?? 'none';
    $vv360    = $annonce->visite_360_images ?? [];
    $vvMatter = $annonce->matterport_url ?? '';
@endphp

@if($vvType !== 'none')
{{-- =============================================
     MODAL VISITE VIRTUELLE — plein écran
     ============================================= --}}
<div id="modalVisiteVirtuelle"
     style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,0.95);
            flex-direction:column;align-items:center;justify-content:center;">

    {{-- Barre titre + fermer --}}
    <div style="position:absolute;top:0;left:0;right:0;display:flex;align-items:center;
                justify-content:space-between;padding:12px 20px;background:rgba(0,0,0,0.6);z-index:2;">
        <span id="vvTitrePiece" style="color:#fff;font-size:16px;font-weight:bold;">
            @if($vvType === 'pannellum' && !empty($vv360))Salon@else Visite Matterport 3D @endif
        </span>
        <button onclick="fermerVisiteVirtuelle()"
                style="background:#27E3C0;border:none;border-radius:50%;width:36px;height:36px;
                       color:#fff;font-size:20px;cursor:pointer;line-height:1;">✕</button>
    </div>

    @if($vvType === 'pannellum')
        <div id="panorama" style="width:100vw;height:100vh;"></div>
    @elseif($vvType === 'matterport')
        <iframe src="{{ $vvMatter }}"
                width="100%" height="100%"
                style="border:none;position:absolute;inset:0;"
                allowfullscreen allow="xr-spatial-tracking"></iframe>
    @endif
</div>

<script>
function fermerVisiteVirtuelle() {
    document.getElementById('modalVisiteVirtuelle').style.display = 'none';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') fermerVisiteVirtuelle();
});

@if($vvType === 'pannellum' && !empty($vv360))
let pannellumInitialized = false;

document.getElementById('modalVisiteVirtuelle')
    .addEventListener('click', function initPannellum() {
        if (pannellumInitialized) return;
        pannellumInitialized = true;

        @php
            $pieceNames = ['Salon','Chambre','Cuisine','Salle de bain','Entrée','Bureau','Terrasse','Jardin','Garage','Autre'];
            $scenes = [];
            foreach ($vv360 as $i => $url) {
                $key = 'scene'.($i+1);
                $scenes[$key] = [
                    'title'    => $pieceNames[$i] ?? 'Pièce '.($i+1),
                    'hfov'     => 110,
                    'pitch'    => -3,
                    'yaw'      => 0,
                    'type'     => 'equirectangular',
                    'panorama' => asset($url),
                    'hotSpots' => [],
                ];
            }
            foreach ($vv360 as $i => $url) {
                if ($i + 1 < count($vv360)) {
                    $scenes['scene'.($i+1)]['hotSpots'][] = [
                        'pitch'   => -10,
                        'yaw'     => 90,
                        'type'    => 'scene',
                        'text'    => $pieceNames[$i+1] ?? 'Pièce '.($i+2),
                        'sceneId' => 'scene'.($i+2),
                    ];
                }
            }
            $firstScene = 'scene1';
        @endphp

        const scenes = @json($scenes);
        const viewer = pannellum.viewer('panorama', {
            default: { firstScene: '{{ $firstScene }}', sceneFadeDuration: 1000, autoLoad: true },
            scenes: scenes,
        });
        viewer.on('scenechange', function(sceneId) {
            const t = scenes[sceneId]?.title ?? '';
            document.getElementById('vvTitrePiece').textContent = t;
        });
    }, { once: true });
@endif
</script>
@endif

@endsection