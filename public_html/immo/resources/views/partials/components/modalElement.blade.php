@php
    $true = true;
@endphp
<!-- Modal -->
<div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ $title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ isset($url) ? url($url) : (isset($route) ? route($route) :'#')}}" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    {{-- La clé nous permet de définir un formulaire --}}
                    @if ($key == "departement")

                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="name" class="col-form-label text-md-right">{{ __("Nom du departement") }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="inputState">Chef du département </label>
                                <select name="collaborateur_id" class="form-control select2" required>
                                    <option value=""> Veuillez choisir le chef du département</option>
                                    @foreach($params1 as $poste)
                                        <option value="{{ $poste->id }}">{{ $poste->name }}</option>
                                    @endforeach()
                                </select>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="inputState">Direction</label>
                                <select id="genre" name="direction_id" class="form-control" required>
                                    @foreach($params as $direction)
                                        <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                                    @endforeach()
                                </select>
                            </div>

                        </div>

                    @elseif ($key == "direction")

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="name" class="col-form-label text-md-right">{{ isset($header) ? $header : __("Nom de la direction") }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="inputState">Directeur</label>
                                <select name="poste_id" class="form-control select2">
                                    <option value=""> Veuillez choisir le directeur </option>
                                    @foreach($params1 as $poste)
                                        <option value="{{ $poste->id }}">{{ $poste->name }}</option>
                                    @endforeach()
                                </select>
                            </div>
                            <!-- div class="col-md-12">
                                <label for="image" class="col-form-label text-md-right">Image de la direction</label>
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div -->
                        </div>

                    @elseif ($key == "zone")

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="name" class="col-form-label text-md-right">{{ isset($header) ? $header : __("Nom de la région") }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @elseif ($key == "groupe")

                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="name" class="col-form-label text-md-right">{{ isset($header) ? $header : __("Nom de l'entite'") }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>
                    @elseif ($key == "service")
                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="name" class="col-form-label text-md-right">{{ __("Nom du service") }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="inputState">Chef de service </label>
                                <select name="collaborateur_id" class="form-control select2">
                                    <option value=""> Veuillez choisir le chef de service </option>
                                    @foreach($params1 as $poste)
                                        <option value="{{ $poste->id }}">
                                            {{ $poste->name }}
                                            @if ($poste->collaborateurs)
                                            <span class=""> --- {{ isset($poste->collaborateurs->first()->nom_complet) ? $poste->collaborateurs->first()->nom_complet : '' }} </span>
                                            @endif
                                        </option>
                                    @endforeach()
                                </select>
                            </div>

                            @foreach($params as $_param)
                                <div class="col-md-12 mt-2">
                                    <label for="{{  $_param['name']  }}" class="{{  $_param['name']  }}">{{  $_param['title']  }}</label>
                                    <select id="{{  $_param['name']  }}" name="{{  $_param['name']  }}" class="select {{  $_param['name']  }} form-control">
                                        <option value="0" selected> Selectionnez {{ $_param['title'] }}</option>
                                        @foreach($_param['values'] as $param)
                                            <option value="{{ $param->id }}">{{ $param->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach()

                        </div>
                    @elseif($key == "collab")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="image" class="col-form-label text-md-right">Upload fichier csv</label> <br>
                                <input type="file" name="file" class="form-control">
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <a href="/img/gerant.csv" download="template_gerant">
                                    Cliquez pour télécharger le fichier modèle
                                </a>
                            </div>
                        </div>
                    @elseif ($key == "fournisseur")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="image" class="col-form-label text-md-right">Upload fichier csv</label> <br>
                                <input type="file" name="file" class="form-control">
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <a href="/img/Template_fournisseurs_V2.csv" download="template_fournisseur">
                                    Cliquez pour télécharger le fichier modèle
                                </a>
                            </div>
                        </div>
                    @elseif ($key == "produit")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="image" class="col-form-label text-md-right">Téléverser le fichier csv</label> <br>
                                <input type="file" name="file" class="form-control">
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <a href="/produit.csv" download="template_produit">
                                    Cliquez pour télécharger le fichier modèle
                                </a>
                            </div>
                        </div>
                    @else
                        @php $true = false; @endphp

                        <div class="form-group row">

                            <div class="col-md-12">
                                <div class="alert alert-danger" role="alert">
                                    Oups !!<br> Aucun formulaire disponible pour cette vue
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                {{-- Vérification de lexistance du formulaire --}}
                @if($true == true)
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

{{-- modal modification --}}

<div class="modal fade" id="editModal"  role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    Modifier la direction
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    {{-- La clé nous permet de définir un formulaire --}}
                    @if ($key == "direction")

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input type="hidden" id="id" name="id" value="">
                                <label for="name" class="col-form-label text-md-right">{{ __("Nom de la direction") }}</label>
                                <input id="direction_name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="inputState">Directeur</label>
                                <select id="poste_id" name="poste_id" class="form-control poste select2" required>
                                    <option value=""> Veuillez choisir le directeur </option>
                                    @foreach($params1 as $poste)

                                        <option value="{{ $poste->id }}">
                                            {{ $poste->name }}
                                            @if (isset($poste->collaborateurs))
                                             <span class=""> --- {{ isset($poste->collaborateurs->first()->nom_complet) ? $poste->collaborateurs->first()->nom_complet : '' }} </span>
                                            @endif
                                        </option>
                                    @endforeach()
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="etat" class="col-form-label text-md-right">{{ __("Etat") }}</label>
                                <select name="etat" id="option" class="form-control">
                                    <option value="1">
                                        Actif
                                    </option>
                                    <option value="0">
                                        Inactif
                                    </option>
                                </select>
                                @error('etat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- div class="col-md-12">
                                <label for="image" class="col-form-label text-md-right">Image de la direction</label>
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div -->
                        </div>
                    @elseif ($key == "groupe")

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input type="hidden" id="id" name="id" value="">
                                <label for="name" class="col-form-label text-md-right">{{ __("Nom de la direction") }}</label>
                                <input id="direction_name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="etat" class="col-form-label text-md-right">{{ __("Etat") }}</label>
                                <select name="etat" id="option" class="form-control">
                                    <option value="1">
                                        Actif

                                    </option>
                                    <option value="0">
                                        Inactif

                                    </option>
                                </select>
                                @error('etat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @elseif($key == "collab")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="image" class="col-form-label text-md-right">Upload fichier csv</label> <br>
                                <input type="file" name="file" class="form-control">
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <a href="/img/gerant.csv" download="template_gerant">
                                    Cliquez pour télécharger le fichier modèle
                                </a>
                            </div>
                        </div>
                    @else
                        @php $true = false; @endphp

                        <div class="form-group row">

                            <div class="col-md-12">
                                <div class="alert alert-danger" role="alert">
                                    Oups !!<br> Aucun formulaire disponible pour cette vue
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script src="{{ asset('js/partials/modalSelect.js') }}"></script>
@endsection


