<style>
    .radius-input,.select{border-radius: 10px !important;font-size: 12px;border: none;
    padding: 8px !important;}
    label{font-size: 12px}
    .inputMaterial{
        gap: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 2px;
    }
</style>
<form method="post" action="{{ route('annonce.search') }}" class="" autocomplete="off" style="margin-top: -62px;position: relative;    border-radius: 10px;overflow: hidden;z-index: 2;">
    @csrf
    @method('POST')
    @isset($form)
        <div class="col-12">
            <div class="row formulaire d-flex justify-content-start">
                <div class="col-4 col-sm-4 col-lg-2 p-0" value="1">
                    <label class="btn btn-secondary col-12 rounded-0" id="louer"   for="Exempleradio1" style="border-radius: 0 15px 0 0;font-size: 16px !important;">
                        <input type="radio" class="d-none radio" name="search[type_location_id]" value="1"  id="Exempleradio1" checked> 
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.067 5c.592.958.933 2.086.933 3.293c0 3.476-2.83 6.294-6.32 6.294c-.636 0-2.086-.146-2.791-.732l-.882.878c-.735.732-.147.732.147 1.317c0 0 .735 1.025 0 2.05c-.441.585-1.676 1.404-3.086 0l-.294.292s.881 1.025.147 2.05c-.441.585-1.617 1.17-2.646.146l-1.028 1.024c-.706.703-1.568.293-1.91 0l-.883-.878c-.823-.82-.343-1.708 0-2.05l7.642-7.61s-.735-1.17-.735-2.78c0-3.476 2.83-6.294 6.32-6.294c.819 0 1.601.155 2.319.437"/><path d="M17.885 8.294a2.2 2.2 0 0 1-2.204 2.195a2.2 2.2 0 0 1-2.205-2.195a2.2 2.2 0 0 1 2.205-2.196a2.2 2.2 0 0 1 2.204 2.196Z"/></g></svg>
                            A Louer</span>
                    </label>
                </div>
                <div class="col-4 col-sm-4 col-lg-2 p-0" value="2">
                    <label class="btn btn-light col-12" id="acheter" for="Exempleradio2" style="border-radius: 0 15px 0 0;font-size: 16px !important;" >
                        <input type="radio" class="d-none radio" name="search[type_location_id]" value="2" id="Exempleradio2">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M11 22v-4H6l-3-3l3-3h5v-2H4V4h7V2h2v2h5l3 3l-3 3h-5v2h7v6h-7v4zM6 8h11.175l1-1l-1-1H6zm.825 8H18v-2H6.825l-1 1zM6 8V6zm12 8v-2z"/></svg>
                            A Vendre</span> 
                    </label>
                </div>
            </div>

        </div>
    @endisset
    <div class="col-12 _btn-focus btn-get-started border-top-1" style="border-radius:0 15px 15px !important;background: #fff;border: 2px solid #0be6cb;">
    {{-- <div class="col-12 p-1 btn-get-started btn-focus"> --}}
        <div class="row p-1">
            {{-- <div class="col-12 col-lg-4 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center" style="gap: 10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="#27E3C0" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.067 5c.592.958.933 2.086.933 3.293c0 3.476-2.83 6.294-6.32 6.294c-.636 0-2.086-.146-2.791-.732l-.882.878c-.735.732-.147.732.147 1.317c0 0 .735 1.025 0 2.05c-.441.585-1.676 1.404-3.086 0l-.294.292s.881 1.025.147 2.05c-.441.585-1.617 1.17-2.646.146l-1.028 1.024c-.706.703-1.568.293-1.91 0l-.883-.878c-.823-.82-.343-1.708 0-2.05l7.642-7.61s-.735-1.17-.735-2.78c0-3.476 2.83-6.294 6.32-6.294c.819 0 1.601.155 2.319.437"/><path d="M17.885 8.294a2.2 2.2 0 0 1-2.204 2.195a2.2 2.2 0 0 1-2.205-2.195a2.2 2.2 0 0 1 2.205-2.196a2.2 2.2 0 0 1 2.204 2.196Z"/></g></svg>
                    <div class="w-100">
                        <label for="">Mot cles</label>
                        <input type="text" name="search[name]" required class="form-control p-1 border-radius-left radius-input" placeholder="Appartement, ...">
                    </div>
                </div>
            </div> --}}
            <div class="col-12 col-lg-3 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 32"><g fill="#27E3C0"><path d="M12 0C5.383 0 0 5.394 0 12.022c0 9.927 11.201 19.459 11.678 19.86a.5.5 0 0 0 .64.004C12.795 31.492 24 22.124 24 12.022C24 5.394 18.617 0 12 0m.002 30.838C10.161 29.193 1 20.579 1 12.022C1 5.944 5.935 1 12 1s11 4.944 11 11.022c0 8.702-9.152 17.193-10.998 18.816"/><path d="M12 6c-3.309 0-6 2.691-6 6s2.691 6 6 6s6-2.691 6-6s-2.691-6-6-6m0 11c-2.757 0-5-2.243-5-5s2.243-5 5-5s5 2.243 5 5s-2.243 5-5 5"/></g></svg>
                    <div class="w-100">
                        <label for="lieu">Lieu</label>
                        {{-- <select name="" class="form-control select2">
                            @foreach ($regions as $region)
                                @if(isset($region["departements"]))
                                    @foreach ($region["departements"] as $departement)
                                        <option disabled>{{ $region['region'] }} -  {{ $departement['departement'] }}</option>
                                        @foreach ($departement['communes'] as $commune)
                                            <option value="">{{ $commune["commune"] }}</option>
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach
                        </select> --}}
                        <input type="text"
                            id="ship-address"
                            required
                            autocomplete="off"
                            name="search[adresse]"
                            required class="form-control p-1 border-radius-left radius-input" placeholder="Dakar,Thies ...">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-2 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 16 16"><path fill="none" stroke="#27E3C0" stroke-linejoin="round" d="M5 10.5h6M2.5 6v7.5h11V6L8 2.5z"/></svg>
                    <div class="w-100">
                        <label for="type">Type de Propriete</label>
                        <select name="search[type]" class="form-control p-1 radius select" required>
                            @foreach ($type_immos as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>            

            <div class="col-12 col-lg-2 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="none" stroke="#27E3C0" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M5 9V6.8c0-.44.36-.8.8-.8h16.4c.44 0 .8.36.8.8v8.4c0 .44-.36.8-.8.8H20M2.8 9h16.4a.8.8 0 0 1 .8.8v8.4a.8.8 0 0 1-.8.8H2.8a.8.8 0 0 1-.8-.8V9.8a.8.8 0 0 1 .8-.8Zm9.2 5a1 1 0 1 1-2 0a1 1 0 0 1 2 0Z"/></svg>
                    <div class="w-100">
                        <label for="">Budget</label>
                        <select name="search[prix]" class="form-control p-1 radius select" required>
                            <option value="20000-50000">20000 - 50000</option>
                            <option value="50000-100000">50000 - 100000</option>
                            <option value="100000-200000">100000 - 200000</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-2 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="none" stroke="#27E3C0" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21v-3m10 3v-6m0-9V3M7 9V3m0 15c-.932 0-1.398 0-1.765-.152a2 2 0 0 1-1.083-1.083C4 16.398 4 15.932 4 15s0-1.398.152-1.765a2 2 0 0 1 1.083-1.083C5.602 12 6.068 12 7 12s1.398 0 1.765.152a2 2 0 0 1 1.083 1.083C10 13.602 10 14.068 10 15s0 1.398-.152 1.765a2 2 0 0 1-1.083 1.083C8.398 18 7.932 18 7 18m10-6c-.932 0-1.398 0-1.765-.152a2 2 0 0 1-1.083-1.083C14 10.398 14 9.932 14 9s0-1.398.152-1.765a2 2 0 0 1 1.083-1.083C15.602 6 16.068 6 17 6s1.398 0 1.765.152a2 2 0 0 1 1.083 1.083C20 7.602 20 8.068 20 9s0 1.398-.152 1.765a2 2 0 0 1-1.083 1.083C18.398 12 17.932 12 17 12" color="#27E3C0"/></svg>
                    <div class="w-100">
                        <label for="">Plus de filtre</label> <br>
                        <span class="text-sm form-control radius select" style="cursor:pointer"  data-toggle="modal" data-target="#exampleModal">
                            Configurer
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-2 col-lg-2 p-1 mb-1 mt-1">
                {{-- <label for="btn"></label> --}}
                <button class="radius btn btn-dark btn-lg p-1 w-100 d-none d-sm-block text-secondary" style="padding: 10px !important;background: #061630 !important"> Rechercher
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="m19.485 20.154l-6.262-6.262q-.75.639-1.725.989t-1.96.35q-2.402 0-4.066-1.663T3.808 9.503T5.47 5.436t4.064-1.667t4.068 1.664T15.268 9.5q0 1.042-.369 2.017t-.97 1.668l6.262 6.261zM9.539 14.23q1.99 0 3.36-1.37t1.37-3.361t-1.37-3.36t-3.36-1.37t-3.361 1.37t-1.37 3.36t1.37 3.36t3.36 1.37"/></svg>
                </button>
                <button class="radius btn btn-danger p-1 w-100 d-block d-sm-none" style="height: 35px;margin-top: 18px;"> <i class="fa fa-search"></i> </button>
            </div>

            {{-- Bouton Géolocalisation --}}
            <div class="col-12 px-2 pb-2">
                <button type="button" id="btnNearMeAccueil" onclick="nearMeRedirect(this)"
                    style="background:none;border:none;color:#888;font-size:12px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;padding:0;">
                    <span style="font-size:14px;">📍</span> Annonces près de moi
                </button>
            </div>
        </div>
    </div>
</form>

<script>
function nearMeRedirect(btn) {
    if (!navigator.geolocation) {
        alert("La géolocalisation n'est pas supportée par votre navigateur.");
        return;
    }
    btn.textContent = '⏳ Localisation en cours...';
    btn.disabled = true;
    navigator.geolocation.getCurrentPosition(function(pos) {
        var lat = pos.coords.latitude;
        var lon = pos.coords.longitude;
        // Redirige vers /louer avec paramètres géo pour déclencher nearMe côté page
        window.location.href = '/louer?near=1&lat=' + lat + '&lon=' + lon + '&rayon=10';
    }, function() {
        btn.disabled = false;
        btn.innerHTML = '<span style="font-size:14px;">📍</span> Annonces près de moi';
        alert("Impossible d'obtenir votre position. Vérifiez les autorisations.");
    });
}
</script>
@include('template.pages.formulaires.modal-tri')

@push('subScript')
    <script>
        $('body').on('click', '.radio', function() {
            if($(this).val() == 2){
                $('#louer').removeClass('btn-secondary')
                $('#acheter').addClass('btn-secondary')
                $('#louer').addClass('btn-light')
            }else{
                $('#acheter').removeClass('btn-secondary')
                $('#louer').addClass('btn-secondary') 
                $('#acheter').addClass('btn-light') 
            }
        })
        // This sample uses the Places Autocomplete widget to:
        // 1. Help the user select a place
        // 2. Retrieve the address components associated with that place
        // 3. Populate the form fields with those address components.
        // This sample requires the Places library, Maps JavaScript API.
        // Include the libraries=places parameter when you first load the API.
        // For example: <script
        // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
        
    </script>
@endpush