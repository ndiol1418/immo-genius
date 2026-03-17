@extends('layouts.auth')

@section('content')
    <div class="card card__login py-3 px-3 shadow-sm  @error('email') @else animate__animated animate__fadeInDown @enderror">
        <div class="card-header bg-white border-0 pt-3">
            <div class="logo d-flex justify-content-center align-items-center">
                {{-- <a href="/" class="btn btn-outline-light2 px-4">{{ config('app.name', '') }}</a> --}}
                <img src="{{ asset('img/logo-teranga.png') }}" alt="logo">
            </div>
            <h3 class="title mt-4 login_police">
              <strong>Connexion</strong>
            </h3>
        </div>

        <div class="card-body pt-0 pb-2">
            {{-- <script src="https://static.kuula.io/embed.js" data-kuula="https://kuula.co/share/collection/7ZxNd?logo=1&info=1&fs=1&vr=0&sd=1&thumbs=1" data-width="100%" data-height="640px"></script> --}}
            <form method="POST" action="{{ route('login') }}" id="demo-form">
                @csrf
                <div class="form-group">
                    <label class="form-check-label small mb-1 login_police">
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
                    <label class="form-check-label small mb-1 login_police">
                        {{ __('Mot de passe') }}
                    </label>
                    <div class="input-group border" style="border-radius: 8px">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Mot de passe">
                        <span class="input-group-btn">
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small" for="remember">
                                {{ __('Se souvenir de moi') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="small link" href="{{ route('password.request') }}">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                        @endif
                    </div>
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
                        <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm"
                        >
                            {{ __('Se connecter') }}
                        </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scriptBottom')
    <script>
        $(function() {
            $("#password").on('change keyup', function(e) {
                var sanitizePassword = $(this).val().trim();
                $(this).val(sanitizePassword);
            });
        });
    </script>
@endsection

<style>
    footer{
        height: 24px !important;
        position: fixed;
        width: 100%;
        bottom: 0;
        background-color: #f8f9fa;
    }
</style>
