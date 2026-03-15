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
<form method="post" action="{{ route('agent.search') }}" class="" autocomplete="off" style="margin-top: -62px;position: relative;    border-radius: 10px;overflow: hidden;z-index: 2;">
    @csrf
    @method('POST')
        <div class="col-12">
            <div class="row formulaire d-flex justify-content-start">
                <div class="col-4 col-sm-4 col-lg-2 p-0" value="1">
                    <label class="btn btn-secondary col-12 rounded-0" id="louer"   for="Exempleradio1" style="border-radius: 0 15px 0 0;font-size: 16px !important;">
                        <input type="radio" class="d-none radio" name="search[type]" value="1"  id="Exempleradio1" checked> 
                        <span>
                            Agent</span>
                    </label>
                </div>
                <div class="col-4 col-sm-4 col-lg-2 p-0" value="2">
                    <label class="btn btn-light col-12" id="acheter" for="Exempleradio2" style="border-radius: 0 15px 0 0;font-size: 16px !important;" >
                        <input type="radio" class="d-none radio" name="search[type]" value="2" id="Exempleradio2">
                        <span>
                            Entreprise</span> 
                    </label>
                </div>
            </div>

        </div>
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
                        <input type="text"
                            id="ship-address"
                            autocomplete="off"
                            name="lieu"
                            class="form-control p-1 border-radius-left radius-input" placeholder="Ville,Departemnt,Quartier ...">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <div class="w-100">
                        <input type="text" name="agent" placeholder="Nom de L'agent" class="form-control p-1 border-radius-left radius-input">
                    </div>
                </div>
            </div>            

            <div class="col-12 col-lg-3 p-1 mb-1 mt-1">
                <div class="d-flex justify-content-left align-items-center inputMaterial" style="gap: 10px">
                    <div class="w-100">
                        <select name="specialisation_id" class="form-control p-1 radius select" required>
                            {{-- <option disabled selected>Service</option> --}}
                            @foreach ($specialisations as $specialisation)
                                <option value="{{ $specialisation->id }}">{{ $specialisation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-2 col-lg-2 p-1 mb-1 mt-1">
                {{-- <label for="btn"></label> --}}
                <button class="radius btn btn-dark btn-lg p-1 w-100 d-none d-sm-block text-secondary text-sm" style="height:38px;background: #061630 !important"> Rechercher 
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="m19.485 20.154l-6.262-6.262q-.75.639-1.725.989t-1.96.35q-2.402 0-4.066-1.663T3.808 9.503T5.47 5.436t4.064-1.667t4.068 1.664T15.268 9.5q0 1.042-.369 2.017t-.97 1.668l6.262 6.261zM9.539 14.23q1.99 0 3.36-1.37t1.37-3.361t-1.37-3.36t-3.36-1.37t-3.361 1.37t-1.37 3.36t1.37 3.36t3.36 1.37"/></svg>
                </button>
                <button class="radius btn btn-danger p-1 w-100 d-block d-sm-none" style="height: 35px;margin-top: 18px;"> <i class="fa fa-search"></i> </button>
            </div>
        </div>
    </div>
</form>
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