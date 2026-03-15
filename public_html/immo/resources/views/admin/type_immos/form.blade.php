{{-- <div class="form-group row"> --}}
    <div class="col-lg-4">
        {{-- <label for="libelle" class="col-form-label text-md-right">{{ __('general.libelle') }}</label> --}}
        <input id="name" type="text" placeholder="{{ __('Saisissez le nouveau libelle') }}" class="form-control @error('name') is-invalid @enderror" name="name"  required autocomplete="name" autofocus>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
{{-- </div> --}}