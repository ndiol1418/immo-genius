    <div class="col-lg-4">
        <input id="name" type="text" placeholder="{{ __('Saisissez le nouveau libelle') }}" class="form-control @error('name') is-invalid @enderror" name="name"  required autocomplete="name" autofocus>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-lg-4">
        <select name="departement_id" id="departement" required class="form-control  @error('departement_id') is-invalid @enderror">
            @foreach ($departements as $departement)
                <option  value="{{ $departement->id }}">{{ $departement->name }}</option>
            @endforeach

        </select>
        @error('departement_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>