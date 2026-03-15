@extends('layouts.auth')

@section('content')
    <div class="card card__login py-4 px-3 shadow-sm  @error('email') @else animate__animated animate__fadeInDown @enderror">
        <div class="card-header bg-white border-0 pt-3">
            <div class="logo d-flex justify-content-between align-items-center">
                <img src="{{ asset('img/logo_total.png') }}" alt="logo">
            </div>
            <h3 class="title">
                Réinitialisez votre mot de passe
            </h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-group border" style="border-radius: 8px">
                        <input id="password" data-toggle="popover" title="Mot de passe" data-placement="left" data-trigger="focus" data-content="Au moins 8 caractères, au moins 1 majuscule, au moins 1 minuscule, et au moins 1 caractère spécial." type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Mot de passe">
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
                    <input id="password-confirm" data-toggle="popover" title="Mot de passe" data-placement="left" data-trigger="focus" data-content="Doit correspondre au mot de passe saisi et être valide aussi." type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmez mot de passe">
                </div>

                <div class="form-group text-right">
                    <button type="submit" id="reset-btn" class="btn btn-primary btn__login shadow-sm">
                        {{ __('Réinitialiser mot de passe') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scriptBottom')
    <script src="{{ asset('js/partials/validationPassword.js') }}"></script>
@endsection
