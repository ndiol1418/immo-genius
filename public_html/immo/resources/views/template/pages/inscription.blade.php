@extends('layouts.accueil',['is_inscription'=>true])
<style>
    .logo img {
    height: 60px;
    width: auto;
}            .page_title {
                width: 70%;
                margin: .7em auto;
                overflow: hidden;
                text-align: center;
                font-weight:300;
                color: #adb4bc !important;
                font-size: 22px;
            }
            .page_title:before, .page_title:after {
                content: "";
                display: inline-block;
                width: 50%;
                margin: 2px .5em 0 -55%;
                vertical-align: middle;
                border-bottom: 1px solid;
                color: #ddd
            }
            .page_title:after {
                margin: 2px -55% 0 .5em;
            }
</style>
@section('content')
<div class="col-12" style="margin:130px 0">
    <div class="container">
        <div class="row d-flex justify-content-between align-items-center">
            
            <div class="col-lg-7 col-12">
                <h3 class="title mt-4 login_police text-center">
                    <strong>Inscription</strong>
                  </h3>
                <div class="card border-0 bg-light py-3 px-3 shadow-none  @error('email') @else animate__animated animate__fadeInDown @enderror">
                    <div class="card-header bg-light border-0 pt-3">
                        <div class="logo d-flex justify-content-center align-items-center">
                            
                        </div>
                    </div>
            
                    <div class="card-body pt-0 pb-2">
                        <form method="POST" action="{{ route('inscriptions.create') }}" id="demo-form">
                            @csrf
                            @include('template.pages.formulaires.form_inscription')
            
                            <div class="form-group d-none">
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
                            <div class="form-group text-right mt-2">
                                    <button type="submit" class="btn btn-primary btn-block shadow-sm g-recaptcha"
                                        {{-- data-sitekey="6Le0Hp4pAAAAAKgWHvh73Hdsn2DyEvzLle1mgo9_"
                                        data-callback='onSubmit'
                                        data-action='submit' --}}
                                    >
                                        {{ __("Valider") }}
                                    </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                @include('template.pages.formulaires.form_login')
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptBottom')
<script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
        document.getElementById("demo-form").submit();
        }
    </script>
    <script>
        $(function() {
            $("#password").on('change keyup', function(e) {
                var sanitizePassword = $(this).val().trim();
                $(this).val(sanitizePassword);
            });
        });

        var onloadCallback = function() {
            alert("grecaptcha is ready!");
        };
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
