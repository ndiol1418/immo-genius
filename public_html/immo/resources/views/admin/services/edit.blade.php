@extends('layouts.admin')
@section('title','Modification du service')
@section('subtitle','Modification du service')

@section('content')

    {{-- Contenu de la page --}}

    <div class="col-md-12">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">


            <!-- Card Content - Collapse -->
            <div class="content-form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="p-0">
                                <form method="POST" action="/admin/services/{{ $service->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="name" class="col-form-label text-md-right">{{ __("Nom du service") }}</label>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $service->name}}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="etat" class="col-form-label text-md-right">{{ __("Etat") }}</label>
                                            <select name="etat" id="" class="form-control">
                                                <option value="1"
                                                    {{ $service->etat == 1 ? "selected" : ""}}
                                                >
                                                    Actif

                                                </option>
                                                <option value="0"
                                                    {{ $service->etat == 0 ? "selected" : ""}}
                                                >
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
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="collaborateur_id" class="collaborateur_id col-form-label text-md-right">{{ __("Chef de service") }}</label>
                                            <select name="poste_id" id="collaborateur_id" class="select collaborateur_id form-control">
                                                <option value="">Selectionnez le chef de service</option>
                                                @foreach ($postes as  $poste)
                                                    <option value="{{ $poste->id }}"
                                                        @if ($poste->id == old('poste_id', $service->poste_id))
                                                            selected="selected"
                                                        @endif
                                                    >
                                                    {{ $poste->name }}
                                                    @if ($poste->collaborateurs)
                                                        <span class=""> --- {{ isset($poste->collaborateurs->first()->nom_complet) ? $poste->collaborateurs->first()->nom_complet : '' }} </span>
                                                    @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('collaborateur_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 departement_id ">
                                            <label for="departement_id" class="departement_id col-form-label text-md-right">{{ __("Departement") }}</label>
                                            <select name="departement_id" id="departement_id" class="select departement_id form-control">
                                                <option value="" >Selectionnez département</option>
                                                @foreach ($departements as  $departement)
                                                    <option value="{{ $departement->id }}"
                                                        @if ($departement->id == old('departement_id', $service->departement_id))
                                                            selected="selected"
                                                        @endif
                                                    >
                                                        {{ $departement->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('departement_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 direction_id">
                                            <label for="direction_id" class="col-form-label direction_id text-md-right">{{ __("Direction") }}</label>
                                            <select name="direction_id" id="direction_id" class="direction_id select form-control" required>
                                                <option value="">Selectionnez direction</option>
                                                @foreach ($directions as  $direction)
                                                    <option value="{{ $direction->id }}"
                                                        @if ($direction->id == old('direction_id', $service->direction_id))
                                                            selected="selected"
                                                        @endif
                                                    >
                                                        {{ $direction->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('direction_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row  mb-0">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary btn-xs">
                                                {{ __('Valider') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
    {{-- Fin contenu --}}
@endsection

@section('scriptBottom')
    <script src="{{ asset('js/partials/modalSelect.js') }}"></script>
@endsection
