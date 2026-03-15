<style>
  .bg-color2{
    background: #27e3c061 !important;
  }
</style>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="    z-index: 10000;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-white" id="exampleModalLabel">Plus de filtre</h5>
        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> --}}
      </div>
      <form action="{{ route('annonce.searchMore') }}" method="POST">
        @csrf
        <div class="modal-body">

          <h5>Location</h5>
          <div class="row">
            @foreach ($type_locations as $k=>$location)
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="defaultCheck{{ $k }}" name="type_location_id"  value="{{ $location->id }}"
                    {{ session('search_type_locations') == $location->id ? 'checked' : '' }}
                    >
                  <label class="form-check-label" for="defaultCheck{{ $k }}">
                    {{ $location->name }}
                  </label>
                </div>
              </div>
            @endforeach

          </div>


          <h5>Type de propriete</h5>
          <div class="row">
            @foreach($type_immos as $key => $type)
              <div class="col-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="{{ $type->id }}" name="type_immo_id[]"
                  {{ in_array( $type->id,session('search_type_immo',[])) ? 'checked' : '' }} 
                  >
                  <label class="form-check-label" for="defaultCheck{{ $type->id }}">
                    {{ $type->name }}
                  </label>
                </div>
              </div>
            @endforeach

          </div>
          <h5>Nombre de chambres</h5>
          <div class="d-flex">
              <table class="table table-bordered">
                <tr>
                  <td class="bg-color2"></td>
                  <td class="text-center">
                      <input type="radio" name="chambres" value="1" {{ session('search_chambres') == 1 ? 'checked':'' }}> +1
                  </td>
                  <td class="text-center">
                      <input type="radio" name="chambres" value="2" {{ session('search_chambres') == 2 ? 'checked':'' }}> +2
                  </td>
                  <td class="text-center">
                      <input type="radio" name="chambres" value="3" {{ session('search_chambres') == 3 ? 'checked':'' }}> +3
                  </td>
                  <td class="text-center">
                      <input type="radio" name="chambres" value="4" {{ session('search_chambres') == 4 ? 'checked':'' }}> +4
                  </td>
                  <td class="text-center">
                      <input type="radio" name="chambres" value="5" {{ session('search_chambres') == 5 ? 'checked':'' }}> +5
                  </td>
              </tr>
              </table>
          </div>
          <h5>Nombre de toilettes</h5>
          <div class="d-flex">
              <table class="table table-bordered">
                <tr>
                  <td class="bg-color2"></td>
                  <td class="text-center">
                      <input type="radio" name="toillettes" value="1" {{ session('search_toillettes') == 1 ? 'checked' : '' }}> +1
                  </td>
                  <td class="text-center">
                      <input type="radio" name="toillettes" value="2" {{ session('search_toillettes') == 2 ? 'checked' : '' }}> +2
                  </td>
                  <td class="text-center">
                      <input type="radio" name="toillettes" value="3" {{ session('search_toillettes') == 3 ? 'checked' : '' }}> +3
                  </td>
                  <td class="text-center">
                      <input type="radio" name="toillettes" value="4" {{ session('search_toillettes') == 4 ? 'checked' : '' }}> +4
                  </td>
                  <td class="text-center">
                      <input type="radio" name="toillettes" value="5" {{ session('search_toillettes') == 5 ? 'checked' : '' }}> +5
                  </td>
              </tr>
              </table>
          </div>
          <h5>Dimensions en M <sup>2</sup></h5>
          <div class="row">
            <div class="col">
              <input class="form-control bg-light" value="{{ session('search_min_size') }}" name="min_size" placeholder="Minimum">
            </div>
            <div class="col">
              <input class="form-control bg-light" value="{{ session('search_max_size') }}" name="max_size" placeholder="Maximum">

            </div>
          </div>

          <br>
          <h5>Meublée</h5>
          <div class="row">
            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="meubles"  {{ session('search_meuble') == 0 ? 'checked' : '' }} value="0"  id="defaultCheck4">
                <label class="form-check-label" for="defaultCheck4">
                  Oui
                </label>
              </div>
            </div>
            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="meubles"  {{ session('search_meuble') == 1 ? 'checked' : '' }} value="1" id="defaultCheck3">
                <label class="form-check-label" for="defaultCheck3">
                  Non
                </label>
              </div>
            </div>
          </div>
          <br>
          <h5>Comodité</h5>

          <div class="row">
            @foreach($comodites as $key => $comodite)
              <div class="col-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="{{ $comodite->id }}" id="defaultCheck{{ $comodite->id }}"  value="{{ $comodite->id }}" 
                    {{ in_array( $comodite->id,session('search_comodites',[])) ? 'checked' : '' }} name="comodites[]">
                  <label class="form-check-label" for="defaultCheck1">
                    {{ $comodite->name }}
                  </label>
                </div>
              </div>
            @endforeach

          </div>
          <br>
          <h5>Visite Virtuelle</h5>
          <div class="row">
            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" name="visite" {{ session('search_meuble') == 0 ? 'checked' : '' }} type="radio" value="0" id="defaultCheck5">
                <label class="form-check-label" for="defaultCheck5">
                  Oui
                </label>
              </div>
            </div>
            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" name="visite" {{ session('search_meuble') == 1 ? 'checked' : '' }}  type="radio" value="1" id="defaultCheck6">
                <label class="form-check-label" for="defaultCheck6">
                  Non
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between align-items-center">
          <button type="submit" class="btn btn-outline-secondary" name="init">Réinitialiser</button>
          <button type="submit" class="btn btn-secondary">Appliquer</button>
        </div>
      </form>

    </div>
  </div>
</div>