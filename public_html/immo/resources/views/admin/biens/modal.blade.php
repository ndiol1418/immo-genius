<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
      <div class="modal-content">
        <form method="POST" id="form" action="{{ route($_espace.'.biens.store') }}">
            @csrf
            @method('POST')
            <div class="modal-header">
              <h5 class="modal-title" id="editLabel">{{ __('Nouveau bien') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row  ">
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('Libelle') }} <span class="text-danger">*</span></label>
                        <input type="text" id="_nom" placeholder="Libelle" name="name" required autofocus class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('Superficie') }} <span class="text-danger">*</span></label>
                        <input type="text" id="_superficie" placeholder="superficie" name="superficie" required autofocus class="form-control">
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('Adresse') }}   <span class="text-danger">*</span></label>
                        <input type="text" id="_adresse" placeholder="Adresse" name="adresse"  autofocus class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('Montant') }}   <span class="text-danger">*</span></label>
                        <input type="number" id="_montant" required placeholder="Montant" name="montant"  autofocus class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.longitude') }}</label>
                        <input type="text" id="_lon"  name="lon"  autofocus class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.latitude') }}</label>
                        <input type="text" id="_lat" name="lat"  autofocus class="form-control">
                    </div>
                    <div class="form-group  col-12 col-lg-6">
                        <label for="name">{{ __('Types biens') }}  <span class="text-danger">*</span></label>
                        <select name="type_bien_id" id="_type_bien" required class="form-control">
                            @foreach ($type_biens as $type_bien)
                                <option  value="{{ $type_bien->id }}">{{ $type_bien->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group  col-12 col-lg-6">
                        <label for="name">{{ __('Types') }}  <span class="text-danger">*</span></label>
                        <select name="type_id" id="_type" required class="form-control">
                            @foreach ($types as $type)
                                <option  value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group  col-12 col-lg-6">
                        <label for="name">{{ __('Commune') }}  <span class="text-danger">*</span></label>
                        <select name="commune_id" id="_commune" required class="form-control">
                            @foreach ($communes as $commune)
                                <option  value="{{ $commune->id }}">{{ $commune->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    {{-- <div class="form-group  col-12 col-lg-6">
                        <label for="name">{{ __('Locations') }}</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">A louer</option>
                            <option value="0">A vendre</option>
                        </select>
                    </div> --}}
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
      </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        
      <div class="modal-content">
        <form method="POST" id="form" action="">
            @csrf
            @method('PATCH')
            <div class="modal-header">
              <h5 class="modal-title" id="editLabel">Modification du bien</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                    <form method="POST" id="form" action="">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="row  ">
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('Libelle') }} <span class="text-danger">*</span></label>
                        <input type="text" id="nom" placeholder="Libelle" name="name" required autofocus class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('Superficie') }} <span class="text-danger">*</span></label>
                        <input type="text" id="superficie" placeholder="superficie" name="superficie" required autofocus class="form-control">
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('Adresse') }}   <span class="text-danger">*</span></label>
                        <input type="text" id="adresse" placeholder="Adresse" name="adresse"  autofocus class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('Montant') }}   <span class="text-danger">*</span></label>
                        <input type="number" id="montant" required placeholder="Montant" name="montant"  autofocus class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.longitude') }}</label>
                        <input type="text" id="lon"  name="lon"  autofocus class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.latitude') }}</label>
                        <input type="text" id="lat" name="lat"  autofocus class="form-control">
                    </div>
                    <div class="form-group  col-12 col-lg-6">
                        <label for="name">{{ __('Types biens') }}  <span class="text-danger">*</span></label>
                        <select name="type_bien_id" id="type_bien" required class="form-control">
                            @foreach ($type_biens as $type_bien)
                                <option  value="{{ $type_bien->id }}">{{ $type_bien->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group  col-12 col-lg-6">
                        <label for="name">{{ __('Types') }}  <span class="text-danger">*</span></label>
                        <select name="type_id" id="type" required class="form-control">
                            @foreach ($types as $type)
                                <option  value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group  col-12 col-lg-6">
                        <label for="name">{{ __('Commune') }}  <span class="text-danger">*</span></label>
                        <select name="commune_id" id="commune" required class="form-control">
                            @foreach ($communes as $commune)
                                <option  value="{{ $commune->id }}">{{ $commune->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    {{-- <div class="form-group  col-12 col-lg-6">
                        <label for="name">{{ __('Locations') }}</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">A louer</option>
                            <option value="0">A vendre</option>
                        </select>
                    </div> --}}
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
      </div>
    </div>
</div>
