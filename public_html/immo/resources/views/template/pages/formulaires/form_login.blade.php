<div class="card border-0 card__login py-3 px-3 shadow-sm @error('email') @else animate__animated animate__fadeInDown @enderror" style="background:#1B5E20;">
    <div class="card-header border-0 pt-3" style="background:#1B5E20;">
        <div class="logo d-flex justify-content-center align-items-center">
            {{-- <a href="/" class="btn btn-outline-light2 px-4">{{ config('app.name', '') }}</a> --}}
            <img src="{{ asset('img/logo-teranga.png') }}" alt="Teranga Immobilier" style="height:60px; width:auto;">
        </div>
        <h3 class="title mt-4 text-white text-white">
          <strong>Connexion</strong>
        </h3>
    </div>

    <div class="card-body pt-0 pb-2">
        <form method="POST" action="{{ route('login') }}" id="demo-form">
            @csrf
            <div class="form-group">
                <label class="form-check-label small mb-1 text-white">
                    {{ __('Identifiant') }}
                </label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus >
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-check-label small mb-1 text-white">
                    {{ __('Mot de passe') }}
                </label>
                <div class="input-group border" style="border-radius: 8px">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Mot de passe">
                    <span class="input-group-btn bg-light rounded">
                        <button class="btn btn-default" type="button" id="showPassword"><i class="fas fa-eye-slash"></i></button>
                    </span>
                </div>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                {{-- @if (env('Gestion_user')) --}}
                    {{-- {!! NoCaptcha::renderJs('fr', false, 'onloadCallback') !!}
                    {!! NoCaptcha::display() !!} --}}
                {{-- @endif --}}


                @if ($errors->has('g-recaptcha-response'))
                    <span class="help-block " role="alert">
                        <strong class="text-danger">{{ $errors->first('g-recaptcha-response') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-right">
                    <button type="submit" class="btn btn-secondary mt-2 btn-block shadow-sm"
                    >
                        {{ __('Se connecter') }}
                    </button>
            </div>
        </form>
    </div>
</div>