@php
    if(isset($liste->attributs) && count($liste->attributs) > 0){
      $attribut = implode(';',$liste->attributs);
    }else $attribut = null;
@endphp
<div class="form-group row">
    <div class="col-md-6">
        <label for="libelle" class="col-form-label text-md-right">{{ __("libellé *") }}</label>
        <input id="libelle" type="text" class="form-control @error('libelle') is-invalid @enderror" name="libelle" value="{{ old('libelle') ?? $liste->libelle }}" required autocomplete="libelle" autofocus>
        @error('libelle')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
   <div class="col-md-6">
        <label for="identifiant" class="col-form-label text-md-right">{{ __("Identifiant ") }}</label>
        <input id="identifiant" type="text" class="form-control @error('identifiant') is-invalid @enderror" name="identifiant" value="{{ old('identifiant') ?? $liste->identifiant }}"  autocomplete="identifiant" autofocus>
        @error('identifiant')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12">
        <label for="attributs" class="col-form-label text-md-right">{{ __("Attributs séparés par (;) *") }}</label> <br>
        <input id="attributs" type="text"  class="form-control" name="attributs" value="{{ old('attributs') ?? $attribut }}" required autocomplete="attributs" autofocus>
        @error('libelle')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12">
        <label for="label" class="col-form-label text-md-right">{{ __("Attribut à afficher *") }}</label> <br>
        <input id="label" type="text" class="form-control" name="label" value="{{ old('label') ?? $liste->label }}" required autocomplete="label" autofocus>
        @error('label')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <label for="file" class="col-form-label text-md-right">{{ __("Fichier en csv *") }}</label>
        <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" required  autofocus>
        @error('file')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>






