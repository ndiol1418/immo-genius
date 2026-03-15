<style>
    .radius-input,.select{border-radius: 10px !important;font-size: 12px;
    padding: 8px !important;}
    label{font-size: 12px}
    .radius-input2{
        border-radius:30px !important;
        border:1px;font-size:10px
    }
@media only screen and (max-width: 600px) {
  .form-search {
    margin-top:0 !important;
  }
}


</style>
<form method="post" action="{{ route('annonce.search') }}" class="form-search" autocomplete="off" style="margin-top: -62px;position: relative;    border-radius: 10px;overflow: hidden;z-index: 2;">
    @csrf
    @method('POST')

    <div class="col-12 _btn-focus border-top-1">
        <div class="row p-1">
            
            <div class="col-12 col-lg-3 py-2">

                <div class="d-flex justify-content-left align-items-center p-1 bg-white" style="gap: 10px;border-radius: 30px;border: 2px solid #0be6cb;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 32"><g fill="#27E3C0"><path d="M12 0C5.383 0 0 5.394 0 12.022c0 9.927 11.201 19.459 11.678 19.86a.5.5 0 0 0 .64.004C12.795 31.492 24 22.124 24 12.022C24 5.394 18.617 0 12 0m.002 30.838C10.161 29.193 1 20.579 1 12.022C1 5.944 5.935 1 12 1s11 4.944 11 11.022c0 8.702-9.152 17.193-10.998 18.816"/><path d="M12 6c-3.309 0-6 2.691-6 6s2.691 6 6 6s6-2.691 6-6s-2.691-6-6-6m0 11c-2.757 0-5-2.243-5-5s2.243-5 5-5s5 2.243 5 5s-2.243 5-5 5"/></g></svg>
                    <div class="w-100">
                        <input type="search" 
                            id="ship-address"
                            required
                            autocomplete="off"
                            name="search[adresse]" 
                            required class="form-control p-1 border-radius-left radius-input2" placeholder="Dakar,Thies ...">
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#0be6cb" stroke-linecap="round" stroke-width="1"><path d="M5 12V4m14 16v-3M5 20v-4m14-3V4m-7 3V4m0 16v-9"/><circle cx="5" cy="14" r="2"/><circle cx="12" cy="9" r="2"/><circle cx="19" cy="15" r="2"/></g></svg>
                </div>
            </div>
           
            <div class="col-12">
                <div class="d-flex justify-content-between  bg-white" style="gap:2px;border-radius: 30px;border: 2px solid #0be6cb;">
                    <select class="btn btn-white dropdown-toggle radius-input2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <option disabled selected>Achats/Locations</option>
                        <option value="achat">Achats</option>
                        <option value="location">Locations</option>
                        <option value="vente">Ventes</option>
                    </select>
                    <select class="btn btn-white dropdown-toggle radius-input2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <option disabled selected>Propriété</option>
                        @foreach ($type_immos as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <select class="btn btn-white dropdown-toggle radius-input2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <option disabled selected>Budget</option>
                        <option value="20000-50000">20000 - 50000</option>
                        <option value="50000-100000">50000 - 100000</option>
                        <option value="100000-200000">100000 - 200000</option>
                    </select>
                </div>
            </div>
            <div class="col-2 col-lg-2 p-1 mb-1 mt-1 d-none">
                <label for="btn"></label>
                <button class="radius btn btn-dark p-1 w-100 d-none d-sm-block text-secondary" style="margin-top: 16px;background: #061630 !important"> Rechercher 
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="m19.485 20.154l-6.262-6.262q-.75.639-1.725.989t-1.96.35q-2.402 0-4.066-1.663T3.808 9.503T5.47 5.436t4.064-1.667t4.068 1.664T15.268 9.5q0 1.042-.369 2.017t-.97 1.668l6.262 6.261zM9.539 14.23q1.99 0 3.36-1.37t1.37-3.361t-1.37-3.36t-3.36-1.37t-3.361 1.37t-1.37 3.36t1.37 3.36t3.36 1.37"/></svg>
                </button>
                <button class="radius btn btn-danger p-1 w-100 d-block d-sm-none" style="height: 35px;margin-top: 18px;"> <i class="fa fa-search"></i> </button>
            </div>
        </div>
    </div>
</form>
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