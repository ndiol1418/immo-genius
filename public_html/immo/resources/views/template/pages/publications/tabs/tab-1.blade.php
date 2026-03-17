<div class="row">

    <div class="col-12">
        <div class="card mb-4">

            <div class="card-body">
                <div class="formbold-form-step-1 active">
                    <div class="row">
                        <h4 class="col-12">Categorié</h4>
            
                        <div class="col-12 col-lg-4">
                            <div class="input-container">
                                <input type="text" id="name" class="form-control form-control-sm @error('name') is-invalid @enderror" value="{{ $annonce?$annonce->name:'' }}" name="immo[name]" placeholder=" " required>
                                <label for="name">Titre de la publication (*)</label>
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-12">
                            <div class="input-container">
                                <select name="immo[type_location_id]" id="type_location_id" class="form-control @error('type_location_id') is-invalid @enderror" required>
                                    @foreach ($type_locations as $type_location)
                                        <option value="{{ $type_location->id }}" {{ isset($annone) && $annonce->type_location_id == $type_location->id ? 'selected' : '' }}>
                                            {{ $type_location->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <label for="type_location_id">Type Location (*)</label>
                            </div>
                            
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="input-container">
                                <select name="immo[type_immo_id]" id="type_immo_id" class="form-control @error('type_immo_id') is-invalid @enderror" required>
                                    @foreach ($type_immos as $type_immo)
                                        <option value="{{ $type_immo->id }}" {{ isset($annone) && $annonce->type_immo_id == $type_immo->id ? 'selected' : '' }}>
                                            {{ $type_immo->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <label for="montant">Type de propriete (*)</label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <h4 class="col-12">Informations Générales</h4>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="input-container">
                            <select name="level_id" id="level_id" class="@error('level_id') is-invalid @enderror" name="immo[level_id]" placeholder=" " required>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                            <label for="montant">Niveau (*)</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="input-container">
                            <input type="text" id="superficie" class="form-control form-control-sm  @error('superficie') is-invalid  @enderror" name="immo[superficie]" value="{{ old('superficie', $annonce?$annonce->superficie:'') }}" placeholder="" required>
                            <label for="superficie">Dimension m<sup>2</sup> (*)</label>
                        </div>
                        @error('superficie')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="input-container">

                            <select name="meuble" id="meuble" class="form-control @error('meuble') is-invalid @enderror" required>
                                <option value="1" {{ isset($annonce)&&$annonce->meuble == 1 ? 'selected' : '' }}>Oui</option>
                                <option value="0" {{ isset($annonce)&&$annonce->meuble == 0 ? 'selected' : '' }}>Non</option>
                            </select>
                            
                        <label for="meuble">Meublé (*)</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="input-container">
                            <input type="date" id="date_disponibilite" class="form-control form-control-sm @error('date_disponibilite') is-invalid @enderror"
                                name="date_disponibilite" value="{{ old('date_disponibilite', isset($annonce)&&$annonce->date_disponibilite ? $annonce->date_disponibilite : '') }}" required>

                            <label for="date_disponibilite">Date de disponiblité (*)</label>
                        </div>
                        @error('date_disponibilite')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="input-container">
                            <input type="number" min="0" id="montant" class="form-control form-control-sm @error('montant') is-invalid @enderror" name="immo[montant]" value="{{ old('montant', $annonce->prix??'') }}" placeholder=" " required>
                            <label for="montant">Montant XOF (*)</label>
                        </div>
                        @error('montant')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12 annonces">
                        <div class="row">
                           <div class="col-12 col-lg-6 ">
                        
                                    <div class="row">
                                        @isset($pieces)
                                            @foreach ($pieces as $k=>$piece)
                                            <div class="col-6 col-sm-3 col-lg-3">
                                                <div class="input-container">
                                                    <input type="number" min="0" id="piece-{{ $piece->name }}" class="form-control form-control-sm"
                                                     name="pieces[{{$piece->id}}][{{ $piece->name }}]" value="{{ $immo&&$immo->annonce?$immo->annonce->pieces[$k+1][$piece->name]:0 }}" required>
                                                    <label for="adresse">{{ $piece->name }}</label>
                                                </div>
                                                {{-- <label for="name" class="col-form-label text-md-right">{{ $piece->name }}</label>
                                                <input id="piece-{{ $piece->name }}" type="number" max="10" min="0" class="form-control form-control-sm" value="{{ $immo&&$immo->annonce?$immo->annonce->pieces[$k+1][$piece->name]:0 }}" 
                                                    name="pieces[{{$piece->id}}][{{ $piece->name }}]" autocomplete="name" autofocus> --}}
                                            </div>
                                            @endforeach
                                        @endisset
                                    </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <label for="name" class="col-form-label text-md-right">{{ __("Description") }}</label>
                        <textarea name="description" id="description" cols="10" rows="4" class="form-control" placeholder="Ex: Bel appartement lumineux, situé à proximité des commerces, idéal pour une famille…”">{{ old('description', $annonce->description??'') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="formbold-form-step-3">
                    <div class="row">
                        <h4 class="col-12">Informations de localisation</h4>

                        <div class="col-12 col-lg-4">
                            <div class="input-container">
                                <input type="text"
                                id="ship-address"
                                value="{{ old('adresse', $annonce->adresse??'') }}"
                                required
                                autocomplete="off"
                                name="adresse"
                                style="background-color:#ffffff !important; color:#333333 !important; color-scheme: light !important;"
                                required placeholder="rue xxx , Dakar">
                                {{-- <input type="text" id="address" required placeholder="Commencez à taper une adresse..." name="immo[adresse]" oninput="handleInput()" autocomplete="off"/>
                                <ul id="suggestions"></ul> --}}
                               
                                {{-- <input type="text" id="adresse" class="form-control form-control-sm @error('adresse') is-invalid @enderror" name="immo[adresse]" placeholder="" required>
                                --}}
                                <label for="adresse">Adresse (*)</label> 
                            </div>
                            @error('adresse')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @php
                            $geoData = [];
                            if(isset($regions)) {
                                foreach($regions as $reg) {
                                    $geoData[$reg->id] = ['name'=>$reg->name,'departements'=>[]];
                                    foreach($reg->departements as $dept) {
                                        $geoData[$reg->id]['departements'][$dept->id] = ['name'=>$dept->name,'communes'=>[]];
                                        foreach($dept->communes as $com) {
                                            $geoData[$reg->id]['departements'][$dept->id]['communes'][$com->id] = $com->name;
                                        }
                                    }
                                }
                            }
                        @endphp
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="input-container">
                                <select name="region" id="region_select" class="form-control" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($regions ?? [] as $reg)
                                        <option value="{{ $reg->name }}" {{ isset($annonce) && $annonce->region == $reg->name ? 'selected' : '' }}>{{ $reg->name }}</option>
                                    @endforeach
                                </select>
                                <label for="region_select">Région (*)</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="input-container">
                                <select name="departement_id" id="departement_id" class="form-control @error('departement_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($departements as $departement)
                                        <option value="{{ $departement->id }}" {{ isset($annonce)&&$annonce->immo&&$annonce->immo->departement_id == $departement->id ? 'selected' : '' }}>{{ $departement->name }}</option>
                                    @endforeach
                                </select>
                                <label for="departement_id">Département (*)</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="input-container">
                                <select name="commune_id" id="commune_id" class="form-control @error('commune_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($communes as $commune)
                                        <option value="{{ $commune->id }}" {{ isset($annonce) && $annonce->immo && $annonce->immo->commune_id == $commune->id ? 'selected' : '' }}>{{ $commune->name }}</option>
                                    @endforeach
                                </select>
                                <label for="commune_id">Commune (*)</label>
                            </div>
                        </div>

                        {{-- Cascade JS data --}}
                        <script>
                        var senegalGeo = @json($geoData ?? []);

                        document.addEventListener('DOMContentLoaded', function() {
                            var regionSel = document.getElementById('region_select');
                            var deptSel   = document.getElementById('departement_id');
                            var commSel   = document.getElementById('commune_id');

                            function findRegionIdByName(name) {
                                for (var rid in senegalGeo) {
                                    if (senegalGeo[rid].name === name) return rid;
                                }
                                return null;
                            }

                            function populateDepts(regionId, selectedDeptId) {
                                deptSel.innerHTML = '<option value="">-- Sélectionner --</option>';
                                commSel.innerHTML = '<option value="">-- Sélectionner --</option>';
                                if (!regionId || !senegalGeo[regionId]) return;
                                var depts = senegalGeo[regionId].departements;
                                for (var did in depts) {
                                    var opt = document.createElement('option');
                                    opt.value = did;
                                    opt.text  = depts[did].name;
                                    if (selectedDeptId && String(selectedDeptId) === String(did)) opt.selected = true;
                                    deptSel.appendChild(opt);
                                }
                            }

                            function populateCommunes(regionId, deptId, selectedCommId) {
                                commSel.innerHTML = '<option value="">-- Sélectionner --</option>';
                                if (!regionId || !deptId || !senegalGeo[regionId] || !senegalGeo[regionId].departements[deptId]) return;
                                var communes = senegalGeo[regionId].departements[deptId].communes;
                                for (var cid in communes) {
                                    var opt = document.createElement('option');
                                    opt.value = cid;
                                    opt.text  = communes[cid];
                                    if (selectedCommId && String(selectedCommId) === String(cid)) opt.selected = true;
                                    commSel.appendChild(opt);
                                }
                            }

                            regionSel.addEventListener('change', function() {
                                var rid = findRegionIdByName(this.value);
                                populateDepts(rid, null);
                            });

                            deptSel.addEventListener('change', function() {
                                var rid = findRegionIdByName(regionSel.value);
                                populateCommunes(rid, this.value, null);
                            });

                            // Restore on edit
                            @if(isset($annonce) && $annonce->region)
                                var initRid = findRegionIdByName("{{ $annonce->region }}");
                                if (initRid) {
                                    populateDepts(initRid, {{ $annonce->immo->departement_id ?? 'null' }});
                                    populateCommunes(initRid, {{ $annonce->immo->departement_id ?? 'null' }}, {{ $annonce->immo->commune_id ?? 'null' }});
                                }
                            @endif
                        });
                        </script>
                        <div class="col-12">
                            <div id="map"></div>
                              
                            <div class="info">
                                <input type="hidden" name="lat" id="lat" value="{{ old('lat', $annonce->lat??'') }}"/>
                                <input type="hidden" name="lon" id="lon" value="{{ old('lon', $annonce->lon??'') }}"/>
                              {{-- <p><strong>Commune :</strong> <span id="commune"></span></p>
                              <p><strong>Région :</strong> <span id="departement"></span></p> --}}
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                    <h4 class="col-12">Comodités</h4>
                
                    <div class="col-lg-12 mt-2 rounded-2 p-2">
                        <div class="row">
                            @php
                                $i = 0;
                            @endphp
                            @foreach($comodites->where('type',1) as $key => $comodite)
                                @if($i == 0)
                                    <div class="col-12">
                                        <strong>
                                            Interieures
                                        </strong>
                                    </div>
                                @endif
                                @include('template.pages.publications.comodites',['comodite'=>$comodite])
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                            
                        </div>
                    </div>
                    <div class="col-lg-12 mt-2 rounded-2 p-2">
                        <div class="row">
                            @php
                                $i = 0;
                            @endphp
                            @foreach($comodites->where('type',0) as $key => $comodite)
                                @if($i == 0)
                                    <div class="col-12">
                                        <strong>
                                            Exterieures
                                        </strong>
                                    </div>
                                @endif
                                @include('template.pages.publications.comodites',['comodite'=>$comodite])
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.visite-virtuelle-form')

</div>