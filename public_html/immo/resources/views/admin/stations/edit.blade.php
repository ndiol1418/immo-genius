@extends('layouts.admin')
@section('title',__('boutique.title_modification'))

@section('content')


    <div class="col-md-12">
        <!-- Collapsable Card Example -->
        <div class="card shadow-none mb-4">
            <!-- Card Header - Accordion -->

            <!-- Card Content - Collapse -->
            <div class="content-form">
                <div class="card-body">
                    <form method="POST" id="form" action="{{ route('admin.stations.update',$station->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.nom') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="nom" placeholder="Nom de la boutique" value="{{ $station->nom }}" name="nom" required autofocus class="form-control">
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.serie') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="serie" placeholder="Serie" value="{{ $station->serie }}" name="serie" required autofocus class="form-control">
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.code') }}  <span class="text-danger">*</span></label>
                                    <input type="text" id="code" value="{{ $station->code }}" required placeholder="Référence" name="code"  autofocus class="form-control">
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.adresse') }}</label>
                                    <input type="text" id="adresse" value="{{ $station->adresse }}" placeholder="Référence" name="adresse"  autofocus class="form-control">
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.longitude') }}</label>
                                    <input type="text" id="lon" value="{{ $station->lon }}" placeholder="longitude" name="lon"  autofocus class="form-control">
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.latitude') }}</label>
                                    <input type="text" id="lat" value="{{ $station->lat }}" placeholder="latitude" name="lat"  autofocus class="form-control">
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.zones') }}  <span class="text-danger">*</span></label>
                                    <select name="zone" id="zone" required class="form-control">
                                        @foreach ($zones as $item)
                                            <option  value="{{ $item->id }}">{{ $item->nom }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.gammes') }}  <span class="text-danger">*</span></label>
                                    <select name="gamme[]" id="gamme" required class="form-control select" multiple>
                                        @foreach ($gammes as $gamme)
                                            <option  value="{{ $gamme->id }}" {{ in_array($gamme->id,$station->gammes()->toArray())?'selected':'' }}>{{ $gamme->nom }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.alcool') }}</label>
                                    <select name="alcool" id="status" class="form-control">
                                        <option value="1" {{ $station->alcool == 1 ? 'selected' : '' }}>Oui</option>
                                        <option value="0" {{ $station->alcool == 0 ? 'selected' : '' }}>Non</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.plateforme') }}</label>
                                    <select name="plateforme" id="status" class="form-control">
                                        <option value="1" {{ $station->plateforme == 1 ? 'selected' : '' }}>OASIS</option>
                                        <option value="0" {{ $station->plateforme == 0 ? 'selected' : '' }}>LEO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
    {{-- Fin contenu --}}
@endsection
