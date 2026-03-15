@extends(isset($admin)?'layouts.admin':'layouts.accueil',['is_inscription'=>true])
<style>
        #map, #map2 {
            width: 100% !important;
            height: 400px;
            margin-top: 10px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
        }
        .info {
            margin-top: 10px;
            font-size: 18px;
        }
        #map { width: 100%; height: 300px !important; margin-top: 10px; }
    input { width: 100%; padding: 10px; font-size: 16px; }

    .info { font-size: 18px; margin-top: 10px; }
    .preview-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }
    .image-preview {
      max-width: 150px;
      max-height: 150px;
      border: 1px solid #ccc;
      padding: 5px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .preview-container>img{
        width: 200px !important;height: 200px !important;
    }
    .upload-box {
      border: 2px dashed #ccc;
      border-radius: 20px;
      background-color: #f8f8f8;
      padding: 40px;
      text-align: center;
      cursor: pointer;
      position: relative;
      transition: border-color 0.3s;
    }

    .upload-box:hover {
      border-color: #999;
    }

    .upload-box .plus {
      font-size: 36px;
      color: #333;
    }

    .upload-box p {
      margin-top: 10px;
      color: #666;
      font-size: 14px;
    }

    #imageInput {
      display: none;
    }

    .preview-container {
      margin-top: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .preview-container img.image-preview {
      max-width: 150px;
      max-height: 150px;
      border-radius: 10px;
      object-fit: cover;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
<style>
    .wrapper {
      /* max-width: 1200px; 4 images * 300px */
      margin: auto;
      overflow: hidden;
      position: relative;
    }
    
    .carousel {
      display: flex;
      gap: 10px;
      overflow-x: auto;
      scroll-behavior: smooth;
      padding: 10px 0;
    }
    
    .carousel img {
      width: 350px;
      height: 200px;
      flex-shrink: 0;
      object-fit: cover;
      border-radius: 10px;
      background: #f0f0f0;
    }
    
    .buttons {
      text-align: center;
      margin-top: 10px;
    }
    
    .buttons button {
      padding: 10px 20px;
      font-size: 18px;
      margin: 0 5px;
      cursor: pointer;
    }
    #carousel {
    display: flex;
    gap: 10px;
    overflow-x: auto;
  }

  .image-wrapper {
    position: relative;
    width: 300px;
    height: 200px;
  }

  .image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
  }

  .remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    line-height: 1;
    display: flex;
    justify-content: center;
    align-items: center;
  }
    </style>
    
@section('content')
<div class="col-12 d-none d-sm-block" style="{{ isset($admin)?'':'margin-top:70px;' }}">

    <div class="container">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-md-12" style="padding: 0 100px">
                <!-- Collapsable Card Example -->
                @php
                    $icon = [
                        '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M5 19h1.425L16.2 9.225L14.775 7.8L5 17.575zm-1 2q-.425 0-.712-.288T3 20v-2.425q0-.4.15-.763t.425-.637L16.2 3.575q.3-.275.663-.425t.762-.15t.775.15t.65.45L20.425 5q.3.275.437.65T21 6.4q0 .4-.138.763t-.437.662l-12.6 12.6q-.275.275-.638.425t-.762.15zM19 6.4L17.6 5zm-3.525 2.125l-.7-.725L16.2 9.225z"/></svg>',
                        '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15l-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></g></svg>',
                        // '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M19.5 22a1.5 1.5 0 0 0 1.5-1.5V17a1.5 1.5 0 0 0-1.5-1.5c-1.17 0-2.32-.18-3.42-.55a1.51 1.51 0 0 0-1.52.37l-1.44 1.44a14.77 14.77 0 0 1-5.89-5.89l1.43-1.43c.41-.39.56-.97.38-1.53c-.36-1.09-.54-2.24-.54-3.41A1.5 1.5 0 0 0 7 3H3.5A1.5 1.5 0 0 0 2 4.5C2 14.15 9.85 22 19.5 22M3.5 4H7a.5.5 0 0 1 .5.5c0 1.28.2 2.53.59 3.72c.05.14.04.34-.12.5L6 10.68c1.65 3.23 4.07 5.65 7.31 7.32l1.95-1.97c.14-.14.33-.18.51-.13c1.2.4 2.45.6 3.73.6a.5.5 0 0 1 .5.5v3.5a.5.5 0 0 1-.5.5C10.4 21 3 13.6 3 4.5a.5.5 0 0 1 .5-.5"/></svg>',
                        '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3.275 15.296C2.425 14.192 2 13.639 2 12c0-1.64.425-2.191 1.275-3.296C4.972 6.5 7.818 4 12 4s7.028 2.5 8.725 4.704C21.575 9.81 22 10.361 22 12c0 1.64-.425 2.191-1.275 3.296C19.028 17.5 16.182 20 12 20s-7.028-2.5-8.725-4.704Z"/><path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0Z"/></g></svg>',
                        '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m4.5 12.75l6 6l9-13.5"/></svg>'
                    ]
                @endphp
                    <div class="content__card mb-0">
                        <div class="row">
                        {{-- @for ($i=0;$i<4;$i++) --}}
                        @php
                            $isActive1 = $immo == null ? 'active' : '';
                            $isActive2 = $immo != null ? 'active' : '';
                        @endphp
                            <div class="col-lg col-sm-6 col-12 step d-flex justify-content-left align-items-center" style="gap: 10px">
                                {{-- <hr class="step__hr"> --}}
                                <span class="step__number">{!! $icon[0] !!}</span>
                                <span class="step__label">Informations de base</span>
                                
                            </div>
                            <div class="col-lg col-sm-6 col-12 step  d-flex justify-content-left align-items-center" style="gap: 10px">
                                {{-- <hr class="step__hr"> --}}
                                <span class="step__number">{!! $icon[1] !!}</span>
                                <span class="step__label">Photos</span>

                            </div>
                            <div class="col-lg col-sm-6 col-12 step  d-flex justify-content-left align-items-center" style="gap: 10px">
                                <span class="step__number">{!! $icon[2] !!}</span>
                                <span class="step__label">Détails de l'annonce</span>
                            </div>
                            <div class="col-lg col-sm-6 col-12 step d-flex justify-content-left align-items-center" style="gap: 10px">
                                <span class="step__number">{!! $icon[3] !!}</span>
                                <span class="step__label">Confirmation</span>
                            </div>
                        {{-- @endfor --}}
                  
                    </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container p-0">
        {{-- <div class="slider" id="previewContainer"></div> --}}
        <div class="wrapper">
            <div class="carousel" id="carousel"></div>
        </div>
        {{-- <div class="preview-container" id="previewContainer"></div> --}}
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12" style="padding: 0 100px">
                @if(isset($annonce) && $annonce && $annonce->images && count($annonce->images))
                    <div class="row mb-3" id="existingImages">
                        @foreach($annonce->images as $image)
                        <div class="col-md-3 mb-3 text-center image-wrapper"  id="image-{{ $image->id }}">
                            <img src="{{ asset($image->url) }}" alt="Image" class="img-fluid rounded" style="max-height: 150px;">
                            
                            <button class="btn btn-sm btn-danger btn-delete-image" data-id="{{ $image->id }}"
                                data-url="{{ route('annonce.image.delete', ['id' => $image->id]) }}" style="width: auto;position: absolute;right: 20px;top: 10px;">
                                X
                            </button>
                        </div>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ isset($annonce) ? route('modifier-annonce.update',$annonce->id) : route('annonce.store') }}" enctype="multipart/form-data" class="">
                    @csrf
                    <div class="col-12">

                        <div class="tab">
                            @include('template.pages.publications.tabs.tab-1',['annonce'=>$annonce??null])
        
                        </div>
                        {{-- Etape 2 --}}
                        <div class="tab">
                            @include('template.pages.publications.tabs.tab-2',['annonce'=>$annonce??null])

                        </div>  

                        {{-- Etape 3 --}}
                        <div class="tab">
                            <div class="row">
                                <div class="card">
        
                                    <div class="card-body">
                                        @include('template.pages.publications.fiche')
        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        {{-- Etape 4 --}}
                        <div class="tab">
                            <div class="row">
                                <div class="card">
        
                                    <div class="card-body">
                                        <div class="col-lg-12 text-center">
                                            <p>
                                                Vous serez recontacté sous peu pour la validation de votre annonce.<br>Nous vous remercions.
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mt-4" style="float:right;">
                        {{-- <div style="overflow:auto;"> --}}
                            <div class="d-flex justify-content-end" style="gap: 10px">
                            <button type="button" id="prevBtn" class="btn btn-xs btn-dark radius text-secondary" onclick="nextPrev(-1)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 32 32"><path fill="none" stroke="#26e3c0" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 16h21M13 8l-8 8l8 8"/></svg>
                                Précèdente</button>
                            <button type="button" id="nextBtn" class="btn btn-xs btn-dark radius text-secondary" onclick="nextPrev(1)">
                                Suivante
                            </button>
                            {{-- </div> --}}
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection

@section('scriptBottom')
    @include('admin.immos.stepJs')
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaSfdQyOwQoWtaDwtL5AMOm3eA492dg9M&callback=initAutocomplete&libraries=places&v=weekly" defer></script>

    <script>
        mapboxgl.accessToken = '{{ config("services.mapbox.token") }}';

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-17.4467, 14.6928], // Dakar
            zoom: 13,
            attributionControl:false,
            draggable: true 
        });
        const map2 = new mapboxgl.Map({
            container: 'map2',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-17.4467, 14.6928], // Dakar
            zoom: 13,
            attributionControl:false,
            draggable: true 
        });

        // let marker = new mapboxgl.Marker();
        marker = new mapboxgl.Marker({ draggable: true });
        let marker2 = new mapboxgl.Marker();
        let timeout = null;

        let autocomplete;

        function initAutocomplete() {
            const address1Field = document.querySelector("#ship-address");
            if (!address1Field) return;

            autocomplete = new google.maps.places.Autocomplete(address1Field, {
                componentRestrictions: { country: ["sn"] },
                fields: ["address_components", "geometry"],
                types: ["address"],
            });

            autocomplete.addListener("place_changed", fillInAddress);
        }

        function fillInAddress() {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();

            map.flyTo({ center: [lng, lat], zoom: 13 });
            map2.flyTo({ center: [lng, lat], zoom: 13 });
            marker.setLngLat([lng, lat]).addTo(map);
            marker2.setLngLat([lng, lat]).addTo(map2);

            document.getElementById('lon').value = lng;
            document.getElementById('lat').value = lat;

            let address1 = "";
            for (const component of place.address_components) {
                const type = component.types[0];
                switch (type) {
                    case "street_number": address1 = `${component.long_name} ${address1}`; break;
                    case "route":        address1 += component.short_name; break;
                }
            }
            document.querySelector("#ship-address").value = address1 || place.formatted_address;

            marker.on('dragend', () => {
                const geocoder = new google.maps.Geocoder();
                const lngLat = marker.getLngLat();
                const newLatLng = { lat: lngLat.lat, lng: lngLat.lng };
                geocoder.geocode({ location: newLatLng }, (results, status) => {
                    if (status === "OK" && results[0]) {
                        document.querySelector("#ship-address").value = results[0].formatted_address;
                    }
                    document.getElementById('lon').value = lngLat.lng;
                    document.getElementById('lat').value = lngLat.lat;
                });
            });
        }

        window.initAutocomplete = initAutocomplete;

    </script>
    <script>
  const uploadInput = document.getElementById('imageInput');
  const carousel = document.getElementById('carousel');
  const leftButton = document.getElementById('left');
  const rightButton = document.getElementById('right');

  uploadInput.addEventListener('change', function (e) {
    const files = e.target.files;
    carousel.innerHTML = ''; // Réinitialiser le carrousel

    Array.from(files).forEach(file => {
      if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (e) {
          const wrapper = document.createElement('div');
          wrapper.classList.add('image-wrapper');

          const img = document.createElement('img');
          img.src = e.target.result;

          const removeBtn = document.createElement('button');
          removeBtn.innerText = 'x';
          removeBtn.classList.add('remove-btn');
          removeBtn.addEventListener('click', () => {
            wrapper.remove();
          });

          wrapper.appendChild(img);
          wrapper.appendChild(removeBtn);
          carousel.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
      }
    });

    setTimeout(startAutoplay, 500);
  });

  const imageWidth = 310; // 300px + 10px (gap)

  leftButton.addEventListener('click', () => {
    carousel.scrollLeft -= imageWidth * 4;
  });

  rightButton.addEventListener('click', () => {
    carousel.scrollLeft += imageWidth * 4;
  });

  let autoplayInterval;
  function startAutoplay() {
    clearInterval(autoplayInterval); // éviter les doublons
    autoplayInterval = setInterval(() => {
      if (carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth) {
        carousel.scrollLeft = 0;
      } else {
        carousel.scrollLeft += imageWidth * 4;
      }
    }, 3000);
  }
    </script>
    {{-- <script>
        const input = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');
        const previewContainer2 = document.getElementById('previewContainer2');

        input.addEventListener('change', function () {
        previewContainer.innerHTML = ""; // Vider l'aperçu précédent
        previewContainer2.innerHTML = ""; // Vider l'aperçu précédent
        const files = Array.from(this.files);

        files.forEach(file => {
            if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement("img");
                const img2 = document.createElement("img");
                img.src = e.target.result;
                img2.src = e.target.result;
                previewContainer.appendChild(img);
                previewContainer2.appendChild(img2);
            };
            reader.readAsDataURL(file);
            }
        });
        });
    </script> --}}
    <script>
        let i = 1;
        let values = [];

        while (true) {
            let input = document.getElementById('comodite-' + i);
            if (input) {
                // values.push(input.value);
                let label = document.querySelector('label[for="comodite-' + i + '"]');
                values.push({
                    texte: label ? label.innerText : 'Pas de label',
                    value: input.value
                });
                console.log(label);
                i++;
            } else {
                break; // Arrêter la boucle si l'input n'existe pas
            }
        }
        let resultatDiv = document.getElementById('comodite');
        resultatDiv.innerHTML = ''; // Vider avant d'afficher

        values.forEach(function(item) {
            resultatDiv.innerHTML += `<li><span>${item.texte}</span></li>`;
        });
    </script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
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
