<div class="card">

    <div class="card-body">

        <div class="formbold-form-step-1 active">
            <div class="row">
        
                @include('components.title-separe', [
                'title' => __('Informations de bases'),
                'class' => 'text-muted mb-2 d-none',
                ])
                <div class="col-12 col-lg-6">
                    <label for="name" class="col-form-label text-md-right">{{ __('Libelle (*)') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="immo[name]" value="{{ old('name') ?? $immo->name }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @if ($immo == null)
                <div class="col-12 col-lg-6">
                    <label for="adresse" class="col-form-label text-md-right">{{ __('Adresse') }}</label>
                    <input id="adresse" type="text" min="0" class="form-control @error('adresse') is-invalid @enderror" name="immo[adresse]" value="{{ old('adresse') ?? $immo->adresse }}" required autocomplete="nom" autofocus placeholder="Lieu">
                    @error('adresse')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @endif
                <div class="col-12 col-lg-6">
                    <label for="montant" class="col-form-label text-md-right">{{ __('Prix (*)') }}</label>
                    <input id="montant" type="number" min="0" class="form-control @error('montant') is-invalid @enderror" name="immo[montant]" value="{{ old('montant') ?? $immo->montant }}" required autocomplete="nom" autofocus>
                    @error('montant')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="formbold-form-step-2">
            <div class="row">
                @include('components.title-separe',[
                'title'=>__('Autres Informations'),
                'class'=>'text-muted mb-2 d-none'
                ])
                <div class="col-md-3 col-sm-6 col-12">
                    <label for="type_immo_id" class="col-form-label">{{ __('Choisissez un type immo') }}</label>
                    @include('partials.components.selectElement', [
                    'options' => $type_immos??[],
                    // 'empty' => "Sélectionner un type immo",
                    "name" => "immo[type_immo_id]",
                    'display' => 'name',
                    'class' => 'select2',
                    'default' => old('type_immo_id') ?? $immo->type_immo_id
                    ])
                </div>
        
                <div class="col-md-3 col-sm-6 col-12">
                    <label for="bien_id" class="col-form-label">{{ __('Choisissez un bien (*)') }}</label>
                    @include('partials.components.selectElement', [
                    'options' => $biens??[],
                    // 'empty' => "Sélectionner un bien",
                    "name" => "immo[bien_id]",
                    'display' => 'name',
                    'class' => 'select2',
                    'default' => old('bien_id') ?? $immo->bien_id
                    ])
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <label for="level_id" class="col-form-label">{{ __('Choisissez un niveau (*)') }}</label>
                    @include('partials.components.selectElement', [
                    'options' => $levels??[],
                    // 'empty' => "Sélectionner un level",
                    "name" => "immo[level_id]",
                    'display' => 'name',
                    'class' => 'select2',
                    'default' => old('level_id') ?? $immo->level_id
                    ])
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <label for="commune_id" class="col-form-label">{{ __('Choisissez une commune (*)') }}</label>
        
                    @include('partials.components.selectElement', [
                    'options' => $communes??[],
                    // 'empty' => "Sélectionner une commune",
                    "name" => $immo==null?"immo[commune_id]":'commune_id',
                    'display' => 'nom_complet',
                    'class' => 'select2',
                    'default' => old('commune_id') ?? $immo->commune_id
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">

    <div class="card-body">
        <div class="formbold-form-step-3">
            <div class="row">
                @isset($annonce)
                <div class="col-12">
                    <div class="form-group">
                        <div class="form-check mt-3 pl-0 rounded bg-light">
                            <input class="form-check-input" type="checkbox" value="" id="annonce">
                            <label class="form-check-label" for="annonce">
                                Voulez-vous faire une annonce ?
                            </label>
                        </div>
                    </div>
                </div>
                @endisset
                {{-- @if ($immo && $immo==null) --}}
        
                <div class="col-12 annonces">
                    <div class="row">
                        @include('components.title-separe',[
                        'title'=>"Détails de l'annonce",
                        'class'=>'text-muted mb-2 d-none'
                        ])
                        @include('admin.annonces.form')
                    </div>
                </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>
    
</div>
