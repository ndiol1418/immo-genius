<style>
    .radius-input2,.select-2{
        border-radius: 10px !important;font-size: 12px;border: none;
        padding: 5px !important;
    }
    label{font-size: 12px}
    .inputMaterial{
        gap: 10px;
        border: 1px solid #81888e85;
        border-radius: 10px;
        padding: 2px;
    }
  .highlight {
    outline: 2px solid #071a5f;
    background-color: #2E7D3254;
    transition: all 0.3s ease;
  }
</style>
<form method="post" action="{{ route('annonce.search') }}" class="" autocomplete="off" style="margin-top: -62px;position: relative;    border-radius: 10px;overflow: hidden;z-index: 2;">
    @csrf
    @method('POST')

    <div class="col-12 _btn-focus btn-get-started border-top-1" style="border-radius:0 15px 15px !important;background: #fff;border: 2px solid #2E7D32;">
    {{-- <div class="col-12 p-1 btn-get-started btn-focus"> --}}
        <div class="row p-1">

            <div class="col-12 col-lg-3 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 32"><g fill="#2E7D32"><path d="M12 0C5.383 0 0 5.394 0 12.022c0 9.927 11.201 19.459 11.678 19.86a.5.5 0 0 0 .64.004C12.795 31.492 24 22.124 24 12.022C24 5.394 18.617 0 12 0m.002 30.838C10.161 29.193 1 20.579 1 12.022C1 5.944 5.935 1 12 1s11 4.944 11 11.022c0 8.702-9.152 17.193-10.998 18.816"/><path d="M12 6c-3.309 0-6 2.691-6 6s2.691 6 6 6s6-2.691 6-6s-2.691-6-6-6m0 11c-2.757 0-5-2.243-5-5s2.243-5 5-5s5 2.243 5 5s-2.243 5-5 5"/></g></svg>

                    <div class="w-100">
                        <label for="lieu">Lieu</label>

                        <input type="text" 
                            id="address"
                            required
                            autocomplete="off"
                            name="search[adresse]" 
                            required class="form-control p-1 border-radius-left radius-input2" placeholder="Rue,Quartier ...">
                        </div>
                    </div>
            </div>
            <div class="col-12 col-lg-2 p-1 mb-1 mt-1 d-none">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <div class="w-100">
                        <label for="type">Achat/Location</label>

                        <select name="search[type]" class="form-control p-1 radius-input2 select-2" id="type">
                            {{-- <option value="" selected disabled>Achat/Location</option> --}}
                            <option value="1" {{ isset($type) && $type =='achat'? 'selected':'' }}>Achat</option>
                            <option value="2" {{ isset($type) && $type =='location'? 'selected':'' }}>Location</option>
                        </select>
                    </div>
                </div>
            </div>            
            <div class="col-12 col-lg-2 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 16 16"><path fill="none" stroke="#2E7D32" stroke-linejoin="round" d="M5 10.5h6M2.5 6v7.5h11V6L8 2.5z"/></svg>
                    <div class="w-100">
                        <label for="type">Type de Propriete</label>
                        <select name="search[type]" class="form-control p-1 radius-input2 select-2" required>
                            @foreach ($type_immos as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>            

            <div class="col-12 col-lg-2 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="none" stroke="#2E7D32" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M5 9V6.8c0-.44.36-.8.8-.8h16.4c.44 0 .8.36.8.8v8.4c0 .44-.36.8-.8.8H20M2.8 9h16.4a.8.8 0 0 1 .8.8v8.4a.8.8 0 0 1-.8.8H2.8a.8.8 0 0 1-.8-.8V9.8a.8.8 0 0 1 .8-.8Zm9.2 5a1 1 0 1 1-2 0a1 1 0 0 1 2 0Z"/></svg>
                    <div class="w-100">
                        <label for="">Budget</label>
                        <select name="search[prix]" class="form-control p-1 radius-input2 select-2" required>
                            <option value="20000-50000">20000 - 50000</option>
                            <option value="50000-100000">50000 - 100000</option>
                            <option value="100000-200000">100000 - 200000</option>
                            <option value="200000-300000">200000 - 300000</option>
                            <option value="300000-400000">300000 - 400000</option>
                            <option value="400000-500000">400000 - 500000</option>
                            <option value="500000-100000">+500000</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-10 col-lg-2 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="none" stroke="#2E7D32" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21v-3m10 3v-6m0-9V3M7 9V3m0 15c-.932 0-1.398 0-1.765-.152a2 2 0 0 1-1.083-1.083C4 16.398 4 15.932 4 15s0-1.398.152-1.765a2 2 0 0 1 1.083-1.083C5.602 12 6.068 12 7 12s1.398 0 1.765.152a2 2 0 0 1 1.083 1.083C10 13.602 10 14.068 10 15s0 1.398-.152 1.765a2 2 0 0 1-1.083 1.083C8.398 18 7.932 18 7 18m10-6c-.932 0-1.398 0-1.765-.152a2 2 0 0 1-1.083-1.083C14 10.398 14 9.932 14 9s0-1.398.152-1.765a2 2 0 0 1 1.083-1.083C15.602 6 16.068 6 17 6s1.398 0 1.765.152a2 2 0 0 1 1.083 1.083C20 7.602 20 8.068 20 9s0 1.398-.152 1.765a2 2 0 0 1-1.083 1.083C18.398 12 17.932 12 17 12" color="#2E7D32"/></svg>
                    <div class="w-100">
                        <label for="">Plus de filtre</label> <br>
                        <span class="text-sm form-control radius-input2 select-2" style="cursor:pointer"  data-toggle="modal" data-target="#exampleModal">
                            Configurer
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-2 col-lg-2 p-1 mb-1 mt-1">
                {{-- <label for="btn"></label> --}}
                <button class="radius btn btn-dark btn-lg p-1 w-100 d-none d-sm-block text-secondary" style="padding: 8px !important;background: #061630 !important"> Rechercher
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="m19.485 20.154l-6.262-6.262q-.75.639-1.725.989t-1.96.35q-2.402 0-4.066-1.663T3.808 9.503T5.47 5.436t4.064-1.667t4.068 1.664T15.268 9.5q0 1.042-.369 2.017t-.97 1.668l6.262 6.261zM9.539 14.23q1.99 0 3.36-1.37t1.37-3.361t-1.37-3.36t-3.36-1.37t-3.361 1.37t-1.37 3.36t1.37 3.36t3.36 1.37"/></svg>
                </button>
                <button class="radius btn btn-danger p-1 w-100 d-block d-sm-none" style="height: 35px;margin-top: 18px;"> <i class="fa fa-search"></i> </button>
            </div>
        </div>
        {{-- Bouton Géolocalisation --}}
        <div class="col-12 px-2 pb-2">
            <button type="button" id="btnNearMeFiltre" onclick="nearMeRedirectFiltre(this)"
                style="background:none;border:none;color:#888;font-size:12px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;padding:0;">
                <span style="font-size:14px;">📍</span> Annonces près de moi
            </button>
        </div>
    </div>
</form>

@push('subScript')
<script>
function nearMeRedirectFiltre(btn) {
    if (!navigator.geolocation) {
        alert("La géolocalisation n'est pas supportée par votre navigateur.");
        return;
    }
    btn.textContent = '⏳ Localisation en cours...';
    btn.disabled = true;
    navigator.geolocation.getCurrentPosition(function(pos) {
        var lat = pos.coords.latitude;
        var lon = pos.coords.longitude;
        window.location.href = '/louer?near=1&lat=' + lat + '&lon=' + lon + '&rayon=10';
    }, function() {
        btn.disabled = false;
        btn.innerHTML = '<span style="font-size:14px;">📍</span> Annonces près de moi';
        alert("Impossible d'obtenir votre position. Vérifiez les autorisations.");
    });
}
</script>
@endpush
@include('template.pages.formulaires.modal-tri')

@push('subScript')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaSfdQyOwQoWtaDwtL5AMOm3eA492dg9M&callback=initAutocomplete&libraries=places&v=weekly" defer></script>

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
        async function initAutocomplete() {
            const { PlaceAutocompleteElement } = await google.maps.importLibrary("places");

            const originalInput = document.querySelector("#address");
            if (!originalInput) return;

            // Insérer un conteneur avant le champ existant et le masquer
            const wrapper = document.createElement("div");
            wrapper.style.cssText = "width:100%;display:flex;align-items:center;";
            originalInput.parentNode.insertBefore(wrapper, originalInput);
            originalInput.type = "hidden";

            const placeAutocomplete = new PlaceAutocompleteElement({
                includedRegionCodes: ["sn"],
            });
            placeAutocomplete.style.cssText = "width:100%;font-size:12px;border:none;";
            wrapper.appendChild(placeAutocomplete);

            placeAutocomplete.addEventListener("gmp-placeselect", async ({ place }) => {
                await place.fetchFields({
                    fields: ["formattedAddress", "addressComponents"],
                });

                let address1 = "";
                let postcode = "";
                for (const component of place.addressComponents) {
                    const type = component.types[0];
                    switch (type) {
                        case "street_number":
                            address1 = `${component.longText} ${address1}`;
                            break;
                        case "route":
                            address1 += component.shortText;
                            break;
                        case "postal_code":
                            postcode = `${component.longText}${postcode}`;
                            address1 += component.shortText;
                            break;
                        case "postal_code_suffix":
                            postcode = `${postcode}-${component.longText}`;
                            break;
                        case "locality": {
                            const el = document.querySelector("#locality");
                            if (el) el.value = component.longText;
                            break;
                        }
                        case "administrative_area_level_1": {
                            const el = document.querySelector("#state");
                            if (el) el.value = component.shortText;
                            break;
                        }
                        case "country": {
                            const el = document.querySelector("#country");
                            if (el) el.value = component.longText;
                            break;
                        }
                    }
                }
                originalInput.value = address1 || place.formattedAddress;
            });
        }
        window.initAutocomplete = initAutocomplete;

    </script>
@endpush