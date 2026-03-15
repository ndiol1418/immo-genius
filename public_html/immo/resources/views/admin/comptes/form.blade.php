<div class="form-group col-6 col-lg-6">
    <label for="fname">Libellé (*)</label>
    <input type="text" name="compte[libelle]" id="libelle" class="form-control @error('compte.libelle') is-invalid @enderror" value="{{ old('compte.libelle')??$compte->libelle }}" required autocomplete="compte.libelle">
    @error('compte.libelle')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group col-6 col-lg-6">
    <label for="pays">Pays (*)</label>
    <select name="compte[pays]" id="" class="form-control">
        @foreach ($pays as $value)
            <option value="{{ $value }}" {{ isset($compte) && $compte->pays == $value ? 'selected' :'' }}>{{ $value }}</option>
        @endforeach
    </select>
    @error('compte.pays')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="col-12">
    <label>Les commandes pour ce compte font-elles l'objet d'une validation ? (*)</label>
</div>

<div class="form-group col-12">
    <input type="radio" name="compte[validation_manager]" id="validation_manager1" class="form-check-input @error('compte.validation_manager') is-invalid @enderror" value="1" {{ isset($compte->validation_manager) && $compte->validation_manager ==  1 ? "checked" : " " }} required>
    <label class="form-check-label" for="validation_manager1">
        OUI
    </label>
    <input type="radio" name="compte[validation_manager]" id="validation_manager2" class="form-check-input @error('compte.validation_manager') is-invalid @enderror" value="0" {{ isset($compte->validation_manager) && $compte->validation_manager ==  0 ? "checked" : " " }} required>
    <label class="form-check-label" for="exampleRadios2">
        NON
    </label>
</div>
@if($compte)
    <div class="form-group col-6 col-lg-6">
        <label for="lat">Latitude</label>
        <input type="text" name="compte[lat]" id="lat" class="form-control @error('compte.lat') is-invalid @enderror" value="{{ old('compte.lat')??$compte->lat }}" autocomplete="compte.lat">
        @error('compte.lat')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group col-6 col-lg-6">
        <label for="lon">Longitude</label>
        <input type="text" name="compte[lon]" id="lon" class="form-control @error('compte.lon') is-invalid @enderror" value="{{ old('compte.lon')??$compte->lon }}" autocomplete="compte.lon">
        @error('compte.lon')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group col-6 col-lg-6">
        <label for="name">Devise (*)</label>
        @if ($devises->count()>0)
            <select name="compte[devise_id]" id="" class="form-control">
                @foreach ($devises as $devise)
                    <option value="{{ $devise->id }}" {{ isset($compte) && $devise->id == $compte->devise_id ? 'selected' :'' }}>{{ $devise->libelle }}</option>
                @endforeach
            </select>
        @else
            <div class="alert alert-warning">
                Veuillez ajouter au moins une devise
            </div>
        @endif
        @error('compte.devise')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@endif

<div class="form-group col-6 col-lg-6">
    <label for="telephone">Téléphone (*)</label>
    <input type="text" name="compte[telephone]" required id="telephone" class="form-control @error('compte.telephone') is-invalid @enderror" value="{{ old('compte.telephone')??$compte->telephone }}" autocomplete="compte.telephone">
    @error('compte.telephone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
{{-- <div class="form-group col-6 col-lg-12">
    <label for="conversion">Conversion en Euro de la monnaie locale (*)</label>
    <input type="float" name="compte[conversion]" required id="conversion" class="form-control @error('compte.conversion') is-invalid @enderror" value="{{ old('compte.conversion')??$compte->conversion }}" autocomplete="compte.conversion">
    @error('compte.conversion')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div> --}}
<div class="form-group col-12">
    <label for="adresse">Adresse (*)</label>
    <textarea name="compte[adresse]" required class="form-control" id="" cols="5" rows="3" value="{{ old('compte.adresse')??$compte->adresse }}">{{ $compte->adresse }}</textarea>
    @error('compte.adresse')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@isset($access)
    <div class="col-12">
        <h4 class="text-divider text-danger"><span>Paramétrage des accès</span></h4>
    </div>

    <div class="col-12">
        <div class="row">
            <div class="form-group col-12 col-lg-6">
                <label for="fname">Prénom & Nom (*)</label>
                <input type="text" name="Nom" id="libelle" class="form-control @error('Nom') is-invalid @enderror" value="{{ old('Nom') }}" required autocomplete="Nom">
                @error('Nom')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-12 col-lg-6">
                <label for="email">Adresse email (*)</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-group col-12 col-sm-6 col-lg-6">
        <label for="password">Saisissez votre mot de passe <small class="small">(longueur 8 caractères minimum)</small> (*)</label>
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
        <label for="password-confirm">Confirmez votre mot de passe (*)</label>
        {{-- <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirmer mot de passe') }}</label> --}}
        <input data-toggle="popover" title="Mot de passe" data-placement="top" data-trigger="focus" data-content="Doit correspondre au mot de passe saisi et être valide aussi." id="password-confirm"  type="password" class="pwd form-control" name="password_confirmation" required  autocomplete="new-password">
    </div>
@endisset
