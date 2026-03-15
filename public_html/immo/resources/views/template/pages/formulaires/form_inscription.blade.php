
<div class="row">
    <div class="row">
        <div class="col-md-6">
            <label for="nom" class="col-form-label text-md-right">{{ __('Nom') }}(*)</label>
            <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="" required autocomplete="name" autofocus>
            @error('nom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="prenom" class="col-form-label text-md-right">{{ __('Prenom') }}(*)</label>
            <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="" required autocomplete="name" autofocus>
            @error('prenom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="contact" class="col-form-label text-md-right">{{ __('fournisseur.telephone') }}(*)</label>
            <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="" required autocomplete="name" autofocus>
            @error('telephone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="adresse" class="col-form-label text-md-right">{{ __('fournisseur.adresse') }}(*)</label>
            <input id="adresse" type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" value="" required autocomplete="name" autofocus>
            @error('adresse')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12 mt-2">
            <label for="">Je suis ?</label>
        </div>
        <div class="col-12">
            <div class="form-check form-check-inline">
                <input class="form-check-input @error('inlineRadioOptions') is-invalid @enderror" type="radio" checked name="inlineRadioOptions" id="inlineRadio1" value="client">
                <label class="form-check-label" for="inlineRadio1">Client</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input @error('inlineRadioOptions') is-invalid @enderror" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="fournisseur">
                <label class="form-check-label" for="inlineRadio2">Agence</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input @error('inlineRadioOptions') is-invalid @enderror" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="fournisseur">
                <label class="form-check-label" for="inlineRadio2">Propriètaire</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input @error('inlineRadioOptions') is-invalid @enderror" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="agent">
                <label class="form-check-label" for="inlineRadio2">Agent</label>
            </div>
            @error('inlineRadioOptions')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<br>
<div class="row">
    @include('components.title-separe',[
        'title'=>__('Configuration des accès'),
        'class'=>'text-muted mb-2'
    ])

    <div class="form-group col-12 col-sm-6 col-lg-12">
        <label class="col-form-label text-md-right">
            {{ __('Adresse email') }}
        </label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus >
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group col-12 col-sm-6 col-lg-6">
        <label class="col-form-label text-md-right">
            {{ __('Mot de passe') }}
        </label>
        <div class="input-group border" style="border-radius: 8px">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Mot de passe">
                <button class="btn btn-default" type="button" id="showPassword"><i class="fas fa-eye-slash"></i></button>
            </span>
        </div>
    
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group col-12 col-sm-6 col-lg-6">
        <label class="col-form-label text-md-right">
            {{ __('Confirm Password') }}
        </label>
        <span class="input-group-btn">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </span>
    </div>
</div>
