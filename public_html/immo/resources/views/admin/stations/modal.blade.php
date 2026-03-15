<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
      <div class="modal-content">
        <form method="POST" id="form" action="{{ route('admin.stations.store') }}">
            @csrf
            @method('POST')
            <div class="modal-header">
              <h5 class="modal-title" id="editLabel">{{ __('boutique.ajout_title') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row  ">
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.nom') }} <span class="text-danger">*</span></label>
                        <input type="text" id="nom" placeholder="Nom de la boutique" name="nom" required autofocus class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.code') }} <span class="text-danger">*</span></label>
                        <input type="text" id="code" placeholder="code de la boutique" name="code" required autofocus class="form-control">
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.adresse') }}   <span class="text-danger">*</span></label>
                        <input type="text" id="adresse" placeholder="Adresse" name="adresse"  autofocus class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.gerant') }}   <span class="text-danger">*</span></label>
                        <input type="text" id="Nom" placeholder="" name="Nom"  autofocus class="form-control">
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
                        <label for="name">{{ __('boutique.zones') }}  <span class="text-danger">*</span></label>
                        <select name="zone_id" id="zone" required class="form-control">
                            @foreach ($zones as $item)
                                <option  value="{{ $item->id }}">{{ $item->nom }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group  col-12 col-lg-6">
                        <label for="name">{{ __('boutique.alcool') }}</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Oui</option>
                            <option value="0">Non</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">{{ __('boutique.gammes') }}  <span class="text-danger">*</span></label>
                    <div class="col-12">
                        @foreach ($gammes as $gamme)

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="{{ $gamme->id }}" name="gamme[]">
                                <label class="form-check-label" for="inlineCheckbox2">{{ $gamme->nom }}</label>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="email">Adresse email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-sm-6 col-lg-6">
                        <label for="password">Saisissez votre mot de passe</label>
                        <div class="input-group border" style="border-radius: 8px">
                            <input data-toggle="popover" title="Mot de passe" data-placement="top" data-trigger="focus" data-content="Au moins 8 caractères, au moins 1 majuscule, au moins 1 minuscule, et au moins 1 caractère spécial." id="password" type="password"  class="pwd form-control @error('password') is-invalid @enderror" name="password" value="" required autocomplete="new-password">
                            <span class="input-group-btn">
                                <button class="btn" type="button" id="showPassword"><i class="fas fa-eye-slash"></i></button>
                            </span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-12  col-sm-6 col-lg-6">
                        <label for="password-confirm">Confirmez votre mot de passe</label>
                        {{-- <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirmer mot de passe') }}</label> --}}
                        <input data-toggle="popover" title="Mot de passe" data-placement="top" data-trigger="focus" data-content="Doit correspondre au mot de passe saisi et être valide aussi." id="password-confirm"  type="password" class="pwd form-control" name="password_confirmation" required  autocomplete="new-password">
                    </div>
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
              <h5 class="modal-title" id="editLabel">Modification du compte</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="name">{{ __('boutique.nom') }} <span class="text-danger">*</span></label>
                    <input type="text" id="nom" placeholder="Nom de la boutique" name="nom" required autofocus class="form-control">
                </div>
                <div class="row">
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.adresse') }}   <span class="text-danger">*</span></label>
                        <input type="text" id="adresse" placeholder="Adresse" name="adresse"  autofocus class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.gerant') }}   <span class="text-danger">*</span></label>
                        <input type="text" id="Nom" placeholder="" name="Nom"  autofocus class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.zones') }}  <span class="text-danger">*</span></label>
                        <select name="zone" id="zone" required class="form-control">
                            @foreach ($zones as $item)
                                <option  value="{{ $item->id }}">{{ $item->nom }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="name">{{ __('boutique.alcool') }}</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Oui</option>
                            <option value="0">Non</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">{{ __('boutique.gammes') }}  <span class="text-danger">*</span></label>
                    <select name="gamme" id="gamme" required class="form-control select" multiple>
                        @foreach ($gammes as $gamme)
                            <option  value="{{ $gamme->id }}">{{ $gamme->nom }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="row">
                    <div class="form-group col-12">
                        <label for="email">Adresse email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-sm-6 col-lg-6">
                        <label for="password">Saisissez votre mot de passe</label>
                        <div class="input-group border" style="border-radius: 8px">
                            <input data-toggle="popover" title="Mot de passe" data-placement="top" data-trigger="focus" data-content="Au moins 8 caractères, au moins 1 majuscule, au moins 1 minuscule, et au moins 1 caractère spécial." id="password" type="password"  class="pwd form-control @error('password') is-invalid @enderror" name="password" value="" required autocomplete="new-password">
                            <span class="input-group-btn">
                                <button class="btn" type="button" id="showPassword"><i class="fas fa-eye-slash"></i></button>
                            </span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-12  col-sm-6 col-lg-6">
                        <label for="password-confirm">Confirmez votre mot de passe</label>
                        {{-- <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirmer mot de passe') }}</label> --}}
                        <input data-toggle="popover" title="Mot de passe" data-placement="top" data-trigger="focus" data-content="Doit correspondre au mot de passe saisi et être valide aussi." id="password-confirm"  type="password" class="pwd form-control" name="password_confirmation" required  autocomplete="new-password">
                    </div>
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
