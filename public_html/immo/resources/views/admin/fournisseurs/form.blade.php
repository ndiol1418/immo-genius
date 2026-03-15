<div class="row">
    <div class="col-md-6">
        <label for="nom" class="col-form-label text-md-right">{{ __('Nom') }}(*)</label>
        <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom')?? $fournisseur->nom }}" required autocomplete="name" autofocus>
        @error('nom')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="prenom" class="col-form-label text-md-right">{{ __('Prenom') }}(*)</label>
        <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom')?? $fournisseur->prenom }}" required autocomplete="name" autofocus>
        @error('prenom')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="contact" class="col-form-label text-md-right">{{ __('fournisseur.telephone') }}(*)</label>
        <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone')?? $fournisseur->telephone }}" required autocomplete="name" autofocus>
        @error('telephone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="adresse" class="col-form-label text-md-right">{{ __('fournisseur.adresse') }}(*)</label>
        <input id="adresse" type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" value="{{ old('adresse')?? $fournisseur->adresse }}" required autocomplete="name" autofocus>
        @error('adresse')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="experience" class="col-form-label text-md-right">{{ __('Experience en mois') }}(*)</label>
        <input id="experience" type="number" class="form-control @error('experience') is-invalid @enderror" name="experience" value="{{ old('experience')?? $fournisseur->experience }}"  autocomplete="name" autofocus>
        @error('experience')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="site" class="col-form-label text-md-right">{{ __('Site web') }}(*)</label>
        <input id="site" type="text" class="form-control @error('site') is-invalid @enderror" name="site" value="{{ old('site')?? $fournisseur->site }}"  autocomplete="name" autofocus>
        @error('site')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="site" class="col-form-label text-md-right">{{ __("Zones d'operation") }}(*)</label>
        <select name="zones[]" id="" class="form-control select" multiple>
            @isset($communes)
                @foreach ($communes as $commune)
                    <option value="{{ $commune->id }}" {{ in_array($commune->id,(isset($fournisseur->zones)?$fournisseur->zones->toArray():[]))?'selected':'' }}>{{ $commune->name  }}</option>
                @endforeach
            @endisset
        </select>
        @error('site')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-12">
        <label for="bio" class="col-form-label text-md-right">{{ __('Biographie') }}(*)</label>
        <textarea id="bio" type="number" class="form-control @error('bio') is-invalid @enderror" name="bio" value="{{ old('bio')?? $fournisseur->bio }}" autocomplete="name" autofocus>{{$fournisseur->bio}}</textarea>
        @error('bio')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="photo" class="col-form-label text-md-right">Photo</label>
        <input type="file" name="images[0][file]" data-rang="0" id="piece_file0" accept="image/png, image/gif, image/jpeg" class="form-control">
    </div>
    <div class="col-md-12">
        <label for="description" class="col-form-label text-md-right">{{ __('Description') }}(*)</label>
        <textarea id="description" type="number" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description')?? $fournisseur->description }}" autocomplete="name" autofocus>{{$fournisseur->description}}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>
<div class="row">
    @include('admin.users.access',['user'=>isset($fournisseur)?$fournisseur->user:null])
</div>