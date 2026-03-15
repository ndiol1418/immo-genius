@extends('layouts.auth')

@section('content')
    <div class="card card__login py-4 px-3 shadow-sm animate__animated animate__fadeInDown">
        <div class="mx-auto mb-1 p-0" style="max-width: 450px">
            @include('flash::message')
        </div>
        <div class="card-header bg-white border-0 pt-3">
            <div class="logo d-flex justify-content-between align-items-center">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary px-4"><i class="fas fa-long-arrow-alt-left"></i></a>
                <img src="{{ asset('img/logo_total.png') }}" alt="logo">
            </div>

            <h3 class="title">
                Réinitialisez votre mot de passe
            </h3>
        </div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="igg" type="text" class="form-control @error('collaborateur.igg') is-invalid @enderror" name="collaborateur.igg" value="{{ old('collaborateur.igg') }}" required autocomplete="igg" placeholder="IGG" autofocus>

                    @error('collaborateur.igg')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Envoyez-moi le lien de réinitialisation') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
