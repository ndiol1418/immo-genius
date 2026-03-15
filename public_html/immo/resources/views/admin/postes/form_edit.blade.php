<div class="form-group row">

    <div class="col-md-12">
        <label for="name" class="col-form-label text-md-right">{{ __("Intitulé du poste") }}</label>
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $poste->name }}" required autocomplete="name" autofocus>

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>



