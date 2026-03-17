@extends('layouts.auth')

@section('content')
    <div class="card card__login py-0 px-0 shadow-sm  @error('email') @else animate__animated animate__fadeInDown @enderror" style="width: 500px !important">
        <div class="card-header bg-white border-0 pt-3">
            <div class="logo d-flex justify-content-between align-items-center mb-0">
                <a href="/" class="btn btn-outline-light2 px-0">{{ config('app.name', 'E-COMMANDE') }}</a>
                <img src="{{ asset('img/logo-teranga.png') }}" alt="Teranga Immobilier" style="height:60px; width:auto;">
            </div>
            {{-- <h3 class="title mt-4 login_police">
                <strong>Connexion</strong>
            </h3> --}}
        </div>

        <div class="card-body">
            @include('flash::message')

            <form method="POST" action="{{ route('2fa.verify') }}">
                @csrf
                <div class="col-lg-12 p-0 text-center">
                    <a href="index.html">
                        <img src="assets/img/svg/logo.svg" alt="">
                    </a>
                    <div class="card shadow-none pb-0 pt-0">
                        <div class="card-body">
                            <div class="svg-icon svg-icon-xl text-purple">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="50" height="50" viewBox="0 0 512 512">
                                    <title>ionicons-v5-g</title>
                                    <path d="M336,208V113a80,80,0,0,0-160,0v95"
                                        style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px">
                                    </path>
                                    <rect x="96" y="208" width="320" height="272" rx="48" ry="48"
                                        style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px">
                                    </rect>
                                </svg>
                            </div>
                            <h3 class="fw-normal text-dark mt-4">2-{{__('general.2fa_title_1') }} </h3>
                            @if(isset($user) && $user->is_scanned == 0)
                                {{ $inlineUrl }}
                                <div class="col-12"> {{ $secret??'' }}</div>
                                <p class="mt-4 mb-1" style="font-size: 12px">{{__('general.2fa_title_2') }} </p>
                            @endif
                            {{-- <img src="{{ asset($inlineUrl??'') }}" alt="" width="100px" height="100px"> --}}
                            <p>{{__('general.2fa_title_3') }}  </p>
                            <div class="row mt-4 pt-2 @error('otp1') is-invalid @enderror">
                                <div class="col input-group"> <input type="text"
                                        class="form-control form-control-lg text-center py-2 px-2 " name="otp1" required maxlength="1" autofocus="">
                                </div>
                                <div class="col input-group">
                                    <input type="text" class="form-control form-control-lg text-center py-2 px-2" name="otp2" required maxlength="1">
                                </div>
                                <div class="col input-group"> <input type="text"
                                        class="form-control form-control-lg text-center py-2 px-2" name="otp3" required maxlength="1"></div>
                                <div class="col input-group"> <input type="text"class="form-control form-control-lg text-center py-2 px-2" name="otp4" required maxlength="1"></div>
                                <div class="col input-group"> <input type="text"class="form-control form-control-lg text-center py-2 px-2" name="otp5" required maxlength="1"></div>
                                <div class="col input-group"> <input type="text"class="form-control form-control-lg text-center py-2 px-2" name="otp6" required maxlength="1"></div>
                            </div>
                            @error('otp1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <a href="#!" class="btn btn-purple btn-lg w-100 hover-lift-light mt-4 d-none">
                                {{ __("general.verifier_compte") }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="form-group row justify-content-center d-flex align-items-center mb-0 mt-4">
                    <div class="col-12 col-lg-6 text-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('general.verify') }}
                        </button>
                    </div>
                </div>
            </form>
            <p class="text-center text-muted mt-4 d-none"> {{ __("general.code_non_recu") }}
                @include('partials.components.postBtnElement',[
                    'url'=>route('2fa.resendCode'),
                    'class'=> $class??' mr-1',
                    'message_confirmation'=>__("general.2fa_message_code"),
                    'entity'=>$_user,
                    'btnInnerHTML'=>__('general.recent_code'),
                    'name'=>'user_id',
                    'value'=>$_user->id
                ])
            </p>
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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const inputs = document.querySelectorAll('.input-group input');

                inputs.forEach((input, index) => {
                    input.addEventListener('input', (event) => {
                        if (input.value.length === 1) {
                            if (index < inputs.length - 1) {
                                inputs[index + 1].focus();
                            } else {
                                // Focus out of the last input
                                input.blur();
                                // Optionally submit the form if all inputs are filled
                                const form = document.getElementById('twoFactorForm');
                                const code = Array.from(inputs).map(input => input.value).join('');
                                document.getElementById('two_factor_code').value = code;
                                form.submit();
                            }
                        }
                    });

                    input.addEventListener('keydown', (event) => {
                        if (event.key === 'Backspace' && input.value === '') {
                            if (index > 0) {
                                inputs[index - 1].focus();
                            }
                        }
                    });
                });
            });
        </script>
@endsection

<style>
    footer {
        height: 24px !important;
        position: fixed;
        width: 100%;
        bottom: 0;
        background-color: #f8f9fa;
    }
</style>
