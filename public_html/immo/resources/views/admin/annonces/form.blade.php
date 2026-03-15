<div class="col-12 col-lg-6 ">
    {{-- <label for="piece" class="col-form-label text-md-right">{{ __("Pieces") }}</label> --}}
    {{-- <div class="card shadow-none rounded">
        <div class="card-body bg-light"> --}}

            <div class="row">
                @isset($pieces)
                    @foreach ($pieces as $k=>$piece)
                    <div class="col-6 col-sm-3 col-lg-3">
                        <label for="name" class="col-form-label text-md-right">{{ $piece->name }}</label>
                        <input id="name" type="number" max="10" min="0" class="form-control form-control-sm" value="{{ $immo&&$immo->annonce?$immo->annonce->pieces[$k+1][$piece->name]:0 }}" 
                            name="pieces[{{$piece->id}}][{{ $piece->name }}]" autocomplete="name" autofocus>
                    </div>
                    @endforeach
                @endisset
            </div>
        {{-- </div>
    </div> --}}
</div>
<div class="col-12 col-lg-3">
    <label for="is_premium" class="col-form-label">{{ __('Premium') }}</label>
    <select name="is_premium" id="is_premium" class="form-control  form-control-sm">
        <option value="0" {{ $immo&&$immo->annonce&&$immo->annonce->is_premium==0?'selected':'' }}>Non</option>
        <option value="1" {{ $immo&&$immo->annonce&&$immo->annonce->is_premium==1?'selected':'' }}>Oui</option>
    </select>
</div>
<div class="col-12 col-lg-3">
    <label for="superficie"
        class="col-form-label text-md-right">{{ __('Superficie (*)') }}</label>
    <input id="superficie" type="number" min="0"
        class="form-control form-control-sm @error('superficie') is-invalid @enderror"
        name="superficie"
        value="{{ old('superficie') ?? $immo&&$immo->annonce?$immo->annonce->superficie:'' }}" required
        autocomplete="nom" autofocus placeholder="m2">
    @error('superficie')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="col-lg-3 col-12">
    <label for="type_location_id" class="col-form-label">{{ __('Choisissez un type de location ou vente (*)') }}</label>
    @include('partials.components.selectElement', [
        'options' => $type_locations??[],
        // 'empty' => "Sélectionner un type immo",
        "name" => "type_location_id",
        'display' => 'name',
        'class' => 'select2',
        'default' => old('type_location_id') ?? null
    ])
</div>
<div class="col-lg-3 col-12">
    <label for="meuble" class="col-form-label">{{ __('Meubles') }}</label>
   <select name="meubles" id="" class="form-control form-control-sm">
        <option value="1"
            {{ $immo&&$immo->annonce&&$immo->annonce->meuble?'selected':'' }}>Oui</option>
        <option value="0" 
            {{ $immo&&$immo->annonce&&!$immo->annonce->meuble?'selected':'' }}>Non</option>
   </select>
</div>
<div class="col-lg-12">
    <label for="meuble" class="col-form-label">{{ __('Comodites') }}</label>
    <div class="row">

        @foreach($comodites as $key => $comodite)
            <div class="col-6 col-lg-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $comodite->id }}" id="defaultCheck{{ $comodite->id }}"  value="{{ $comodite->id }}" 
                name="comodites[]">
                <label class="form-check-label" for="defaultCheck1">
                {{ $comodite->name }}
                </label>
            </div>
            </div>
        @endforeach
    </div>
</div>
@include('partials.uploadMultipleFiles')

{{-- ===== Visite Virtuelle (admin) ===== --}}
<div class="col-12 mt-3">
    <div class="card border">
        <div class="card-body">
            <h6 class="card-title">Visite Virtuelle</h6>
            <div class="row">
                <div class="col-12 col-lg-4">
                    <label class="col-form-label">Type</label>
                    <select name="visite_virtuelle_type" class="form-control form-control-sm">
                        <option value="none"       {{ ($immo&&$immo->annonce&&$immo->annonce->visite_virtuelle_type=='none')?'selected':'' }}>Aucune</option>
                        <option value="pannellum"  {{ ($immo&&$immo->annonce&&$immo->annonce->visite_virtuelle_type=='pannellum')?'selected':'' }}>Photos 360° (Pannellum)</option>
                        <option value="matterport" {{ ($immo&&$immo->annonce&&$immo->annonce->visite_virtuelle_type=='matterport')?'selected':'' }}>Matterport 3D</option>
                    </select>
                </div>
                <div class="col-12 col-lg-8">
                    <label class="col-form-label">URL Matterport</label>
                    <input type="text"
                           name="matterport_url"
                           class="form-control form-control-sm"
                           value="{{ $immo&&$immo->annonce?$immo->annonce->matterport_url:'' }}"
                           placeholder="https://my.matterport.com/show/?m=XXXXX">
                    <small class="text-muted">Uniquement si le type est Matterport 3D</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-lg-12">
    <label for="name" class="col-form-label text-md-right">{{ __("Description") }}</label>
    <textarea name="description" id="description" cols="10" rows="4" class="form-control">{{ $immo&&$immo->annonce?$immo->annonce->description:'' }}</textarea>
    @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>