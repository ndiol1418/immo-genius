@extends('layouts.accueil')

@php
    $typeLabel   = isset($type) && $type == 1 ? 'Acheter' : (isset($type) && $type == 2 ? 'Louer' : 'Acheter ou louer');
    $searchName  = $search['name']    ?? null;
    $searchAddr  = $search['adresse'] ?? null;
    $nbResultats = count($annonces);

    $pageTitle = $typeLabel . ' un bien immobilier au Sénégal';
    if ($searchName) $pageTitle = $typeLabel . ' ' . $searchName . ($searchAddr ? ' à ' . $searchAddr : '') . ' au Sénégal';

    $descSeo = "Découvrez {$nbResultats} annonce" . ($nbResultats > 1 ? 's' : '') . " immobilière" . ($nbResultats > 1 ? 's' : '')
        . ($searchName  ? " de type {$searchName}" : '')
        . ($searchAddr  ? " à {$searchAddr}" : ' au Sénégal')
        . ". Achat, location, villa, appartement, terrain — trouvez votre bien sur " . config('app.name') . '.';

    $keywordsSeo = implode(', ', array_filter([
        $searchName,
        $searchAddr,
        'annonces immobilières Sénégal',
        'acheter maison Sénégal',
        'louer appartement Dakar',
        'immobilier Sénégal',
        config('app.name'),
    ]));
    $canonicalUrl = request()->fullUrl();
    $ogImage = asset('img/og-default.png');
@endphp

@section('title', $pageTitle . ' | ' . config('app.name'))

@section('meta')
    {{-- Description & Keywords --}}
    <meta name="description" content="{{ $descSeo }}">
    <meta name="keywords" content="{{ $keywordsSeo }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="website">
    <meta property="og:site_name"   content="{{ config('app.name') }}">
    <meta property="og:url"         content="{{ $canonicalUrl }}">
    <meta property="og:title"       content="{{ $pageTitle }} | {{ config('app.name') }}">
    <meta property="og:description" content="{{ $descSeo }}">
    <meta property="og:image"       content="{{ $ogImage }}">
    <meta property="og:locale"      content="fr_SN">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $pageTitle }} | {{ config('app.name') }}">
    <meta name="twitter:description" content="{{ $descSeo }}">
    <meta name="twitter:image"       content="{{ $ogImage }}">
@endsection

<style>
  #map { height: 750px}
  td{font-size: 12px}
  .btn-danger{
    background: rgb(203, 33, 33)
  }
</style>
<style>
  .price-marker {
    background: #0d1c2e;
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: bold;
    font-size: 12px;
    cursor: pointer;
  }

  .custom-popup {
    width: 200px;
  }

  .custom-popup img {
    width: 100%;
    border-radius: 8px;
  }

  .custom-popup h4 {
    margin: 8px 0 4px;
    font-size: 16px;
  }

  .custom-popup p {
    margin: 0;
    font-size: 13px;
    color: #555;
  }
  .mapboxgl-popup-content {
    border-radius: 10px !important;
}
</style>
@section('content')

  
      <!-- Services Section -->
    <section id="services" class="services section mt-4">
  
        <!-- Section Title -->
        {{-- <p class="places" style="font-family: roboto, sans-serif">Search for a place here:</p> --}}
        <div class="container d-none d-sm-block" style="margin-top:100px;">
          @include('template.filtre-achat-vente',['type'=>isset($type)?$type:''])
        </div>
        <div class="container d-block d-sm-none" style="margin-top:50px;">
          @include('template.filtre-mobile')
        </div>

        <div class="container section-title mt-4 d-none d-sm-block" data-aos="fade-up">
          <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
            <div class="d-flex align-items-center" style="gap:10px;flex-wrap:wrap;">
              <p class="mb-0" id="nbResultats">{{ count($annonces) }}  @isset($_GET['name']) {{ $_GET['name'].'(s)' }}@endisset trouvé(e)s</p>
              {{-- Bouton Géolocalisation --}}
              <button id="btnNearMe" onclick="rechercherProchesMoi()"
                style="background:#0d1c2e;color:#2E7D32;border:none;border-radius:20px;padding:6px 14px;font-size:12px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;">
                📍 Annonces près de moi
              </button>
              {{-- Slider rayon (caché initialement) --}}
              <div id="rayonContainer" style="display:none;align-items:center;gap:8px;">
                <label style="font-size:12px;white-space:nowrap;">Rayon : <strong id="rayonVal">10</strong> km</label>
                <input type="range" id="rayonSlider" min="1" max="50" value="10"
                  oninput="document.getElementById('rayonVal').textContent=this.value;rechercherProchesMoi()"
                  style="width:120px;">
                <button onclick="resetNearMe()" style="background:none;border:1px solid #ccc;border-radius:12px;padding:2px 10px;font-size:11px;cursor:pointer;">✕</button>
              </div>
            </div>
            @php
              $alerteParams = array_filter([
                'type_transaction' => isset($search['type_location_id']) ? ($search['type_location_id'] == 1 ? 'louer' : 'acheter') : null,
                'type_bien'        => $search['type'] ?? null,
                'commune'          => $search['adresse'] ?? null,
              ]);
            @endphp
            <a href="{{ route('alertes.index', $alerteParams) }}"
               style="background:#2E7D32;color:#fff;border-radius:20px;padding:7px 16px;font-size:12px;font-weight:bold;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2m6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1z"/></svg>
              Créer une alerte pour cette recherche
            </a>
          </div>
          </div>
          @isset($search['name'])
            <p>
              <span class="badge btn-primary text-sm text-capitalize">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 100 100"><path fill="currentColor" d="M35.002 0C15.764 0 0 15.719 0 34.902c0 7.433 2.374 14.339 6.393 20.018L30.73 96.994c3.409 4.453 5.674 3.608 8.508-.234l10.227-17.405a29.8 29.8 0 0 1-10.528-8.685a29.77 29.77 0 0 1-6.1-17.356C23.52 52.261 16.4 44.5 16.4 34.902c0-10.33 8.243-18.548 18.602-18.548c6.736 0 12.558 3.487 15.818 8.757a29.9 29.9 0 0 1 17.098-2.017C63.033 9.669 50.09 0 35.002 0"/><path fill="currentColor" d="M66.129 27.495c-6.422-.87-13.175.702-18.72 4.925c-11.09 8.444-13.247 24.366-4.802 35.456c7.905 10.38 22.34 12.883 33.25 6.237l2.083 2.736a2.69 4.051 52.712 0 0 .106 2.494l15.12 19.855a2.69 4.051 52.712 0 0 4.852-.314a2.69 4.051 52.712 0 0 1.594-4.595l-15.12-19.855a2.69 4.051 52.712 0 0-2.376-.765l-2.084-2.737c9.31-8.75 10.737-23.33 2.833-33.71c-4.223-5.546-10.314-8.857-16.736-9.727m-.75 5.537a19.62 19.62 0 0 1 13.013 7.596a19.635 19.635 0 0 1-3.735 27.577a19.635 19.635 0 0 1-27.576-3.735a19.635 19.635 0 0 1 3.734-27.576a19.6 19.6 0 0 1 14.564-3.862" color="currentColor"/></svg>
                {{ $search['name'] }}</span>
              <span class="badge btn-secondary text-sm text-capitalize">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16"><g fill="currentColor"><path d="M10 6.5a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path d="M7.193 15.162a18 18 0 0 1-2.666-2.283C3.1 11.386 1.5 9.145 1.5 6.5C1.5 3.245 4.141 0 8 0s6.5 3.245 6.5 6.5c0 2.645-1.6 4.886-3.027 6.379a18 18 0 0 1-2.666 2.283c-.263.183-.536.351-.807.523c-.27-.172-.544-.34-.807-.523M8 2C5.359 2 3.5 4.232 3.5 6.5c0 1.855 1.15 3.614 2.473 4.996A16 16 0 0 0 8 13.28a16 16 0 0 0 2.027-1.783C11.35 10.114 12.5 8.356 12.5 6.5C12.5 4.232 10.641 2 8 2"/></g></svg>
                {{ $search['adresse'] }}</span>
              <span class="badge btn-danger text-sm text-capitalize">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48"><circle cx="29.218" cy="29.218" r="13.282" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M25.115 34.294a3.96 3.96 0 0 0 3.32 1.494h1.993a3.32 3.32 0 0 0 0-6.641h-2.159a3.32 3.32 0 1 1 0-6.641h1.993A3.57 3.57 0 0 1 33.582 24m-4.317-3.32v16.602m-12.77-12.59a4.47 4.47 0 0 1-1.413-3.277v-4.317a4.464 4.464 0 0 1 4.483-4.482a4.67 4.67 0 0 1 3.487 1.66M13.09 17.43h5.645m-5.645 3.32h5.645"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M16.02 31.774a13.282 13.282 0 1 1 15.754-15.753"/></svg>
                {{ $search['prix'] }}</span>
            </p>
          @endisset
        </div><!-- End Section Title -->
        <div class="container mt-2">
            <div class="row">
              <div class="col-lg-6 col-12">
                <div class="row" style="max-height:750px;overflow-y:auto">
                 @include('template.pages.component-annonces')
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div id="map"></div>
              </div>
            </div>
        </div>
      <div class="container">
        <div class="d-flex d-block d-sm-none" style="justify-content: center;position: fixed;bottom: 90;z-index: 100;left: 0;right: 0;gap: 10px;    background: #061630;left: 70;right: 70;border-radius: 30px;">
          <button type="button" class="btn btn-primary2 text-white text-sm" data-toggle="modal" data-target="#exampleModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 6v15m0-15l6-3v15l-6 3m0-15L9 3m6 18l-6-3m0 0l-6 3V6l6-3m0 15V3"/></svg>
            Carte
          </button>
          <button type="button" class="btn btn-primary2 text-white text-sm" data-toggle="modal" data-target="#exampleModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1"><path d="M5 12V4m14 16v-3M5 20v-4m14-3V4m-7 3V4m0 16v-9"/><circle cx="5" cy="14" r="2"/><circle cx="12" cy="9" r="2"/><circle cx="19" cy="15" r="2"/></g></svg>
            Trier par
          </button>

        </div>
      </div>
    </section><!-- /Services Section -->
    @include('template.pages.formulaires.modal-tri')
@endsection

@section('scriptBottom')
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.0/mapbox-gl.js"></script>
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.0/mapbox-gl.css" rel="stylesheet">
  <script>
    const select = document.getElementById('mySelect');
    const type = document.getElementById('type');
    const price = document.getElementById('price');

    select.addEventListener('change', function () {
      // Ajoute la classe "highlight"
      this.classList.add('highlight');

      // Retire la surbrillance après 1 seconde
      // setTimeout(() => {
      //   this.classList.remove('highlight');
      // }, 1000);
    });
    type.addEventListener('change', function () {
      // Ajoute la classe "highlight"
      this.classList.add('highlight');
    });
    price.addEventListener('change', function () {
      // Ajoute la classe "highlight"
      this.classList.add('highlight');
    });

  </script>
  <script>
    mapboxgl.accessToken = '{{ config("services.mapbox.token") }}';

    const map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [-17.4467, 14.6928], // Dakar
      zoom: 10,
      attributionControl: false
    });

    // Bouton "Me localiser" sur la carte
    class LocaliserControl {
        onAdd(map) {
            this._map = map;
            this._container = document.createElement('div');
            this._container.className = 'mapboxgl-ctrl mapboxgl-ctrl-group';
            this._container.innerHTML = `<button title="Me localiser" style="font-size:18px;line-height:1;padding:4px 8px;" onclick="rechercherProchesMoi()">📍</button>`;
            return this._container;
        }
        onRemove() { this._container.parentNode.removeChild(this._container); this._map = undefined; }
    }
    map.addControl(new LocaliserControl(), 'top-right');
    map.addControl(new mapboxgl.NavigationControl({ showCompass: false }), 'top-right');
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
    const datas = @json($annonces);
    const array = [];

    datas.forEach(element=>{
      var item = element.immo;
      // var type = element.type_immo;
      // var url = '' 

      if (element.immo && item.lon!== null && item.lat!== null) {   
        console.log(element.pieces);
        
          array.push(
            {
              coords: [element.lon!== undefined ? parseFloat(element.lon):0, element.lat!== undefined ? parseFloat(element.lat):0],
              price: kConverter(element.prix),
              image: element.images && element.images.length > 0 ? element.images[0].url : '',
              city: element.adresse,
              priceText: element.prix+' CFA',
              type: element.immo.name,
              chambre: element?.pieces?.[1] ? element.pieces[1]['Chambres'] : 0,
              cuisine: element?.pieces?.[4] ? element.pieces[4]['Cuisines'] : 0,
              salon: element?.pieces?.[2] ? element.pieces[2]['Salons'] : 0,
              toilette: element?.pieces?.[3] ? element.pieces[3]['Toilettes'] : 0
          })
          // coords = [parseInt(item.lon), parseInt(item.lat)]
      }
    });
    console.log(array);
    
    array.forEach(loc => {
      // Crée un marker custom (comme une bulle de prix)
      const el = document.createElement('div');
      el.className = 'price-marker';
      el.textContent = loc.price;

      const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
        // `<strong>${loc.city}</strong><br>${loc.city}`
        `<div class="custom-popup">
            <img src="${asset(loc.image)}" alt="photo">
            <h4>${loc.priceText}</h4>
            <p><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4s-4 1.794-4 4s1.794 4 4 4m0-6c1.103 0 2 .897 2 2s-.897 2-2 2s-2-.897-2-2s.897-2 2-2"/><path fill="currentColor" d="M11.42 21.814a1 1 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819M12 4c3.309 0 6 2.691 6 6.005c.021 4.438-4.388 8.423-6 9.73c-1.611-1.308-6.021-5.294-6-9.735c0-3.309 2.691-6 6-6"/></svg> ${loc.city} <br>  ${loc.type}</p>
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 48 48"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"><path d="M9 25a5 5 0 1 0 10 0a5 5 0 1 0-10 0m10.23-6.487c.136-1.366 1.26-2.387 2.631-2.443c5.229-.216 10.06.098 13.939.545c5.456.628 9.2 5.405 9.2 10.897V28a2 2 0 0 1-2 2H21.204c-.969 0-1.793-.694-1.904-1.655A47 47 0 0 1 19 23.1c0-1.795.11-3.387.23-4.587"/><path d="M6.979 11.033c1.125.082 1.786 1.003 1.835 2.13C8.899 15.118 9 19.103 9 27q0 1.7-.006 3.166C11.363 30.086 15.813 30 24 30h18.982c1.108 0 2.005.902 1.997 2.01c-.032 4.672-.106 7.338-.17 8.826c-.05 1.127-.71 2.049-1.835 2.13a14 14 0 0 1-1.958.001c-1.125-.082-1.786-1.004-1.835-2.131c-.045-1.022-.093-2.6-.13-5.003c-2.357.08-6.812.167-15.051.167c-8.245 0-12.7-.087-15.056-.167a183 183 0 0 1-.13 5.004c-.049 1.127-.71 2.048-1.835 2.13Q6.556 42.999 6 43c-.556.001-.696-.013-.979-.033c-1.125-.082-1.786-1.003-1.835-2.13C3.101 38.882 3 34.897 3 27s.101-11.882.186-13.837c.049-1.127.71-2.048 1.835-2.13Q5.444 11.002 6 11c.556-.002.696.012.979.033"/></g></svg>
              ${loc.chambre}
            </span>

            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 12.749h4.5a1.5 1.5 0 0 0 1.5-1.5v-9a1.5 1.5 0 0 0-1.5-1.5h-3a1.5 1.5 0 0 0-1.5 1.5zm-12-3a1.5 1.5 0 1 0 0 3h12v-3zM19.7 15.6a3 3 0 0 0 2.047-2.845H5.25a8.25 8.25 0 0 0 4.5 7.35L9 23.25h9.75v-6.22a1.49 1.49 0 0 1 .95-1.431M4.192 7.436a3.48 3.48 0 0 1 3.245-3.25M.75 6.893A6.954 6.954 0 0 1 6.892.751"/></svg>
              ${loc.toilette}
            </span>
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32"><path fill="currentColor" d="M28 13a2 2 0 0 1 2 2v6.064a.936.936 0 0 1-.936.936H28v1a2 2 0 0 1-4 0v-1H8v1a2 2 0 0 1-4 0v-1H2.936A.936.936 0 0 1 2 21.064V15a2 2 0 0 1 4 0v2h20v-2a2 2 0 0 1 2-2M8 15a4 4 0 0 0-4-4V9a2 2 0 0 1 2-2h20a2 2 0 0 1 2 2v2a4 4 0 0 0-4 4z"/></svg>
              ${loc.salon}
            </span>
                      <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16.88" height="15" viewBox="0 0 576 512"><path fill="currentColor" d="M240 144a96 96 0 1 0-192 0a96 96 0 1 0 192 0m44.4 32c-14.5 64.1-71.9 112-140.4 112C64.5 288 0 223.5 0 144S64.5 0 144 0c68.5 0 125.9 47.9 140.4 112h71.8c8.8-9.8 21.6-16 35.8-16h104c26.5 0 48 21.5 48 48s-21.5 48-48 48H392c-14.2 0-27-6.2-35.8-16zM144 80a64 64 0 1 1 0 128a64 64 0 1 1 0-128m256 160c13.3 0 24 10.7 24 24v8h96c13.3 0 24 10.7 24 24s-10.7 24-24 24H280c-13.3 0-24-10.7-24-24s10.7-24 24-24h96v-8c0-13.3 10.7-24 24-24M288 464V352h224v112c0 26.5-21.5 48-48 48H336c-26.5 0-48-21.5-48-48M48 320h128c26.5 0 48 21.5 48 48s-21.5 48-48 48h-16c0 17.7-14.3 32-32 32H64c-17.7 0-32-14.3-32-32v-80c0-8.8 7.2-16 16-16m128 64c8.8 0 16-7.2 16-16s-7.2-16-16-16h-16v32zM24 464h176c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24s10.7-24 24-24"/></svg>
              ${loc.cuisine}
            </span>
          </div>`
      );

      new mapboxgl.Marker(el)
        .setLngLat(loc.coords)
        .setPopup(popup)
        .addTo(map);

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
    function getAdresseComplete(annonce) {
        if (annonce.commune) {
          const adresse = annonce.adresse ?? '---';
          const commune = annonce.commune.name ?? '';
          const departement = annonce.commune.departement?.name ?? '';
          return `${adresse}, ${commune}, ${departement}`;
        } else {
          return annonce.adresse ?? '---';
        }
    }
    function asset(path) {
      return `${window.location.origin}/${path.replace(/^\/+/, '')}`;
    }
    function kConverter(num) {
          return num <= 999 ? num : (0.1 * Math.floor(num / 100)).toFixed(1).replace('.0','') + 'k';
      }

    // ─── Géolocalisation — Annonces près de moi ───────────────────────────
    var userMarker = null;
    var userCircle = null;
    var nearMeActive = false;

    function rechercherProchesMoi() {
        if (!navigator.geolocation) {
            alert("La géolocalisation n'est pas supportée par votre navigateur.");
            return;
        }
        var btn = document.getElementById('btnNearMe');
        btn.textContent = '⏳ Localisation...';
        btn.disabled = true;

        navigator.geolocation.getCurrentPosition(function(pos) {
            var lat   = pos.coords.latitude;
            var lon   = pos.coords.longitude;
            var rayon = parseInt(document.getElementById('rayonSlider').value) || 10;

            // Centre la carte sur l'utilisateur
            map.flyTo({ center: [lon, lat], zoom: 11 });

            // Marqueur utilisateur
            if (userMarker) userMarker.remove();
            var el = document.createElement('div');
            el.style.cssText = 'width:18px;height:18px;background:#2E7D32;border:3px solid #fff;border-radius:50%;box-shadow:0 0 0 4px rgba(46,125,50,.3)';
            userMarker = new mapboxgl.Marker(el).setLngLat([lon, lat]).addTo(map);

            // Cercle de rayon (approximation visuelle via GeoJSON)
            if (map.getSource('user-circle')) {
                map.getSource('user-circle').setData(makeCircle(lon, lat, rayon));
            } else {
                map.addSource('user-circle', { type: 'geojson', data: makeCircle(lon, lat, rayon) });
                map.addLayer({ id: 'user-circle-fill', type: 'fill', source: 'user-circle',
                    paint: { 'fill-color': '#2E7D32', 'fill-opacity': 0.1 } });
                map.addLayer({ id: 'user-circle-line', type: 'line', source: 'user-circle',
                    paint: { 'line-color': '#2E7D32', 'line-width': 2 } });
            }

            // Fetch annonces proches via AJAX
            fetch('{{ route("annonces.nearMe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ lat, lon, rayon })
            })
            .then(r => r.json())
            .then(data => {
                btn.textContent = '📍 Annonces près de moi';
                btn.disabled = false;
                document.getElementById('rayonContainer').style.display = 'flex';
                document.getElementById('nbResultats').textContent = data.total + ' annonce(s) dans un rayon de ' + rayon + ' km';
                nearMeActive = true;

                // Afficher les résultats dans la liste
                var listContainer = document.querySelector('.row[style*="max-height"]');
                if (listContainer) {
                    if (data.annonces.length === 0) {
                        listContainer.innerHTML = '<div class="col-12 p-4 text-center text-muted">Aucune annonce trouvée dans ce rayon.</div>';
                    } else {
                        listContainer.innerHTML = data.annonces.map(a => `
                            <div class="col-12 col-sm-6 mb-3">
                                <a href="${a.url}" class="text-decoration-none text-dark">
                                    <div class="card border-0 shadow-sm">
                                        ${a.image ? `<img src="/${a.image.replace(/^\/+/,'')}" class="card-img-top" style="height:120px;object-fit:cover;" alt="">` : ''}
                                        <div class="card-body p-2">
                                            <div class="fw-bold" style="font-size:13px;">${Number(a.prix).toLocaleString('fr-FR')} CFA</div>
                                            <div style="font-size:11px;color:#888;">${a.commune ?? ''}</div>
                                            <div style="font-size:11px;color:#2E7D32;">📍 ${a.distance} km</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        `).join('');
                    }
                }
            })
            .catch(() => {
                btn.textContent = '📍 Annonces près de moi';
                btn.disabled = false;
                alert('Erreur lors de la recherche.');
            });
        }, function() {
            btn.textContent = '📍 Annonces près de moi';
            btn.disabled = false;
            alert("Impossible d'obtenir votre position.");
        });
    }

    function resetNearMe() {
        nearMeActive = false;
        if (userMarker) { userMarker.remove(); userMarker = null; }
        if (map.getLayer('user-circle-fill')) map.removeLayer('user-circle-fill');
        if (map.getLayer('user-circle-line')) map.removeLayer('user-circle-line');
        if (map.getSource('user-circle')) map.removeSource('user-circle');
        document.getElementById('rayonContainer').style.display = 'none';
        document.getElementById('nbResultats').textContent = '{{ count($annonces) }} trouvé(e)s';
        location.reload();
    }

    // Génère un polygone circulaire en GeoJSON
    function makeCircle(cx, cy, radiusKm, points=64) {
        var coords = [], d = radiusKm / 6371;
        var lat1 = cy * Math.PI / 180, lon1 = cx * Math.PI / 180;
        for (var i = 0; i < points; i++) {
            var brng = (i * 360 / points) * Math.PI / 180;
            var lat2 = Math.asin(Math.sin(lat1)*Math.cos(d) + Math.cos(lat1)*Math.sin(d)*Math.cos(brng));
            var lon2 = lon1 + Math.atan2(Math.sin(brng)*Math.sin(d)*Math.cos(lat1), Math.cos(d)-Math.sin(lat1)*Math.sin(lat2));
            coords.push([lon2 * 180/Math.PI, lat2 * 180/Math.PI]);
        }
        coords.push(coords[0]);
        return { type: 'Feature', geometry: { type: 'Polygon', coordinates: [coords] } };
    }
    // ──────────────────────────────────────────────────────────────────────

    // Auto-trigger nearMe si URL contient ?near=1&lat=...&lon=...
    (function() {
        var params = new URLSearchParams(window.location.search);
        if (params.get('near') === '1' && params.get('lat') && params.get('lon')) {
            var lat = parseFloat(params.get('lat'));
            var lon = parseFloat(params.get('lon'));
            var rayon = parseInt(params.get('rayon')) || 10;
            document.getElementById('rayonSlider').value = rayon;
            document.getElementById('rayonVal').textContent = rayon;

            map.once('load', function() {
                triggerNearMeWithCoords(lat, lon, rayon);
            });
        }
    })();

    function triggerNearMeWithCoords(lat, lon, rayon) {
        var btn = document.getElementById('btnNearMe');
        if (btn) { btn.textContent = '⏳ Chargement...'; btn.disabled = true; }

        fetch('{{ route("annonces.nearMe") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ lat: lat, lon: lon, rayon: rayon })
        })
        .then(r => r.json())
        .then(data => {
            if (btn) { btn.innerHTML = '📍 Annonces près de moi'; btn.disabled = false; }
            document.getElementById('rayonContainer').style.display = 'flex';
            document.getElementById('nbResultats').textContent = data.total + ' annonce(s) dans un rayon de ' + rayon + ' km';
            nearMeActive = true;

            var listEl = document.getElementById('annonces-list');
            if (listEl) {
                listEl.innerHTML = '';
                data.annonces.forEach(function(a) {
                    listEl.innerHTML += `<div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a href="/annonces/${a.id}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm">
                                <img src="${a.image || '/img/logo-teranga.png'}" class="card-img-top" style="height:160px;object-fit:cover;">
                                <div class="card-body p-2">
                                    <p class="mb-1 fw-bold" style="font-size:13px;">${a.name}</p>
                                    <p class="mb-0 text-muted" style="font-size:12px;">${Number(a.prix).toLocaleString('fr-FR')} CFA</p>
                                    <p class="mb-0" style="font-size:11px;color:#2E7D32;">📍 ${(a.distance).toFixed(1)} km</p>
                                </div>
                            </div>
                        </a>
                    </div>`;
                });
            }

            if (userMarker) userMarker.remove();
            userMarker = new mapboxgl.Marker({ color: '#2E7D32' }).setLngLat([lon, lat]).addTo(map);
            map.flyTo({ center: [lon, lat], zoom: 12 });

            if (map.getSource('user-circle')) {
                map.getSource('user-circle').setData(makeCircle(lon, lat, rayon));
            } else {
                map.addSource('user-circle', { type: 'geojson', data: makeCircle(lon, lat, rayon) });
                map.addLayer({ id: 'user-circle-fill', type: 'fill', source: 'user-circle', paint: { 'fill-color': '#2E7D32', 'fill-opacity': 0.1 } });
                map.addLayer({ id: 'user-circle-line', type: 'line', source: 'user-circle', paint: { 'line-color': '#2E7D32', 'line-width': 2 } });
            }
        })
        .catch(function() {
            if (btn) { btn.innerHTML = '📍 Annonces près de moi'; btn.disabled = false; }
        });
    }

  </script>
  <script>
    let timeout = null;

    async function handleInput() {
      clearTimeout(timeout);
      const input = document.getElementById('address').value;

      if (!input) {
        document.getElementById('suggestions').innerHTML = '';
        return;
      }

      timeout = setTimeout(async () => {
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(input)}.json?access_token=${mapboxgl.accessToken}&country=SN&types=place,locality,address`;

        try {
          const res = await fetch(url);
          
          const data = await res.json();
          console.log(data);
          const list = document.getElementById('suggestions');
          list.innerHTML = '';

          data.features.forEach(feature => {
            const li = document.createElement('li');
            li.textContent = feature.place_name;
            li.onclick = () => selectAddress(feature);
            list.appendChild(li);
          });
        } catch (err) {
          console.error("Erreur lors de la récupération des suggestions", err);
        }
      }, 500); // délai anti spam
    }

    function selectAddress(feature) {
      const [lng, lat] = feature.center;
      const context = feature.context;
      let commune = "Non trouvée";
      let region = "Non trouvée";

      context.forEach(item => {
        if (item.id.includes("place")) {
          commune = item.text;
        }
        if (item.id.includes("region")) {
          region = item.text;
        }
      });

      document.getElementById('address').value = feature.place_name;
      document.getElementById('suggestions').innerHTML = '';
      // document.getElementById('commune').textContent = commune;
      // document.getElementById('departement').textContent = region;
      document.getElementById('lon').value = lng;
      document.getElementById('lat').value = lat;

      map.flyTo({ center: [lng, lat], zoom: 13 });
      marker.setLngLat([lng, lat]).addTo(map);
    }
  </script>
@endsection


<style>
    footer{
        height: 24px !important;
        position: fixed;
        width: 100%;
        bottom: 0;
        background-color: #f8f9fa;
    }
</style>
