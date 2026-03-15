@extends('layouts.accueil')
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
          {{-- <h2>Dernieres Publications</h2> --}}
          <p>{{ count($annonces) }}  @isset($_GET['name']) {{ $_GET['name'].'(s)' }}@endisset trouvé(e)s</p>
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
    mapboxgl.accessToken = 'pk.eyJ1Ijoidnl0aW1vIiwiYSI6ImNtOThpNnNpNDAyZnYyanNlbmR1dDFpMjcifQ.Z3zUfwJ59hZX2t6V5cE8Tw';

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
