  <!-- Modal -->
  <style>
    .actif{
      background: no-repeat;
      color: #071a5f !important;
      border-bottom: 2px solid #26e3c0;
      border-radius: 0 !important;
      text-align: left;
    }
  </style>
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}
  <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000000">
    <div class="modal-dialog modal-dialog-centered" style="width: 350px">
      <div class="modal-content">
        <div class="d-flex justify-content-end">
          <h5 class="modal-title" id="staticBackdropLabel"></h5>
          <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
            {{-- <span aria-hidden="true">&times;</span> --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20"><path fill="currentColor" d="M2.93 17.07A10 10 0 1 1 17.07 2.93A10 10 0 0 1 2.93 17.07m1.41-1.41A8 8 0 1 0 15.66 4.34A8 8 0 0 0 4.34 15.66m9.9-8.49L11.41 10l2.83 2.83l-1.41 1.41L10 11.41l-2.83 2.83l-1.41-1.41L8.59 10L5.76 7.17l1.41-1.41L10 8.59l2.83-2.83z"/></svg>
          </button>
        </div>
        <div class="modal-body mt-0">
          <div style="border: 0px solid !important" class="card shadow-none border-0 card__login shadow-sm  @error('email') @else animate__animated animate__fadeInDown @enderror">
            <div class="card-header bg-white border-0 pt-0">
                <div class="logo d-flex justify-content-center align-items-center mb-4">
                    {{-- <a href="/" class="btn btn-outline-light2 px-4">{{ config('app.name', '') }}</a> --}}
                    <img src="{{ asset('img/logo-teranga.png') }}" alt="logo" width="100px">
                </div>
                {{-- <h4 class="title mt-4 login_police text-center">
                  <strong>Connexion</strong>
                </h4> --}}
                <ul class="nav nav-pills nav-fill mb-2">
                  <li class="nav-item">
                    <a class="nav-link actif p-1" href="#">Se connecter</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link p-1" href="{{ route('inscriptions') }}" style="color: #071a5f !important">S'inscrire</a>
                  </li>
                </ul>
            </div>
    
            <div class="card-body pt-0 pb-2">
                {{-- <script src="https://static.kuula.io/embed.js" data-kuula="https://kuula.co/share/collection/7ZxNd?logo=1&info=1&fs=1&vr=0&sd=1&thumbs=1" data-width="100%" data-height="640px"></script> --}}
                <form method="POST" action="{{ route('login') }}" id="demo-form">
                    @csrf
                    <div class="form-group mb-3">
                        <input id="email" placeholder="Email" type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus >
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
    
                    <div class="form-group mb-3">
                       
                        <div class="input-group border" style="border-radius: 8px">
                            <input id="password" type="password" placeholder="Mot de passe" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Mot de passe">
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
    
                    <div class="form-group mb-4 text-right">
                        <div class="d-flex justify-content-end mt-2 align-items-center">
                            @if (Route::has('password.request'))
                                <a class="small link text-sm" href="{{ route('password.request') }}">
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
                            <button type="submit" class="btn btn-primary btn-sm btn-block shadow-sm _g-recaptcha col-12"
                                {{-- data-sitekey="6Le0Hp4pAAAAAKgWHvh73Hdsn2DyEvzLle1mgo9_"
                                data-callback='onSubmit'
                                data-action='submit' --}}
                            >
                                {{ __('Se connecter') }}
                            </button>
                    <h4 class="col-12 page_title {{ $class??'text-muted-light' }}">ou</h4>

                      <a href="{{ route('socialite.redirect', 'facebook') }}" class="btn btn-outline-light btn-sm col-12 border">
                        <div class="row d-flex justify-content-between align-items-center">
                          <div class="col-12 col-lg-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 256 256"><path fill="#1877f2" d="M256 128C256 57.308 198.692 0 128 0S0 57.308 0 128c0 63.888 46.808 116.843 108 126.445V165H75.5v-37H108V99.8c0-32.08 19.11-49.8 48.348-49.8C170.352 50 185 52.5 185 52.5V84h-16.14C152.959 84 148 93.867 148 103.99V128h35.5l-5.675 37H148v89.445c61.192-9.602 108-62.556 108-126.445"/><path fill="#fff" d="m177.825 165l5.675-37H148v-24.01C148 93.866 152.959 84 168.86 84H185V52.5S170.352 50 156.347 50C127.11 50 108 67.72 108 99.8V128H75.5v37H108v89.445A129 129 0 0 0 128 256a129 129 0 0 0 20-1.555V165z"/></svg>
                          </div>
                          <div class="col-6 col-lg-10 text-dark text-sm" style="text-align: left">
                            Se connecter avec Facebook
                          </div>
                        </div>
                      </a>
                      <a href="{{ route('socialite.redirect', 'google') }}" class="btn btn-outline-light btn-sm col-12 mt-2 border">
                        <div class="row d-flex justify-content-between align-items-center">
                          <div class="col-12 col-lg-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 128 128"><path fill="#fff" d="M44.59 4.21a63.28 63.28 0 0 0 4.33 120.9a67.6 67.6 0 0 0 32.36.35a57.13 57.13 0 0 0 25.9-13.46a57.44 57.44 0 0 0 16-26.26a74.3 74.3 0 0 0 1.61-33.58H65.27v24.69h34.47a29.72 29.72 0 0 1-12.66 19.52a36.2 36.2 0 0 1-13.93 5.5a41.3 41.3 0 0 1-15.1 0A37.2 37.2 0 0 1 44 95.74a39.3 39.3 0 0 1-14.5-19.42a38.3 38.3 0 0 1 0-24.63a39.25 39.25 0 0 1 9.18-14.91A37.17 37.17 0 0 1 76.13 27a34.3 34.3 0 0 1 13.64 8q5.83-5.8 11.64-11.63c2-2.09 4.18-4.08 6.15-6.22A61.2 61.2 0 0 0 87.2 4.59a64 64 0 0 0-42.61-.38"/><path fill="#e33629" d="M44.59 4.21a64 64 0 0 1 42.61.37a61.2 61.2 0 0 1 20.35 12.62c-2 2.14-4.11 4.14-6.15 6.22Q95.58 29.23 89.77 35a34.3 34.3 0 0 0-13.64-8a37.17 37.17 0 0 0-37.46 9.74a39.25 39.25 0 0 0-9.18 14.91L8.76 35.6A63.53 63.53 0 0 1 44.59 4.21"/><path fill="#f8bd00" d="M3.26 51.5a63 63 0 0 1 5.5-15.9l20.73 16.09a38.3 38.3 0 0 0 0 24.63q-10.36 8-20.73 16.08a63.33 63.33 0 0 1-5.5-40.9"/><path fill="#587dbd" d="M65.27 52.15h59.52a74.3 74.3 0 0 1-1.61 33.58a57.44 57.44 0 0 1-16 26.26c-6.69-5.22-13.41-10.4-20.1-15.62a29.72 29.72 0 0 0 12.66-19.54H65.27c-.01-8.22 0-16.45 0-24.68"/><path fill="#319f43" d="M8.75 92.4q10.37-8 20.73-16.08A39.3 39.3 0 0 0 44 95.74a37.2 37.2 0 0 0 14.08 6.08a41.3 41.3 0 0 0 15.1 0a36.2 36.2 0 0 0 13.93-5.5c6.69 5.22 13.41 10.4 20.1 15.62a57.13 57.13 0 0 1-25.9 13.47a67.6 67.6 0 0 1-32.36-.35a63 63 0 0 1-23-11.59A63.7 63.7 0 0 1 8.75 92.4"/></svg>
                          </div>
                          <div class="col-6 col-lg-10 text-dark text-sm" style="text-align: left">
                            Se connecter avec Google
                          </div>
                        </div>
                      </a>
                    </div>
                </form>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>