@extends('layouts.admin')
@section('title',__('Modification'))

@section('content')


    <div class="col-md-12">
        <!-- Collapsable Card Example -->
        <div class="card shadow-none mb-4">
            <!-- Card Header - Accordion -->

            <!-- Card Content - Collapse -->
            <div class="content-form">
                <div class="card-body">
                    <form method="POST" id="form" action="{{ route('admin.biens.update',$bien->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="row  ">
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('Libelle') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="_nom" placeholder="Libelle" name="name" value="{{ $bien->name }}" required autofocus class="form-control">
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('Superficie') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="_superficie" placeholder="superficie" name="superficie" value="{{ $bien->superficie }}" required autofocus class="form-control">
                                </div>
            
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('Adresse') }}   <span class="text-danger">*</span></label>
                                    <input type="text" id="_adresse" placeholder="Adresse" name="adresse" value="{{ $bien->adresse }}"  autofocus class="form-control">
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('Montant') }}   <span class="text-danger">*</span></label>
                                    <input type="number" id="_montant" required placeholder="Montant" name="montant" value="{{ $bien->montant }}"  autofocus class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.longitude') }}</label>
                                    <input type="text" id="_lon"  name="lon"  autofocus value="{{ $bien->lon }}" class="form-control">
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="name">{{ __('boutique.latitude') }}</label>
                                    <input type="text" id="_lat" name="lat"  autofocus value="{{ $bien->lat }}" class="form-control">
                                </div>
                                <div class="form-group  col-12 col-lg-6">
                                    <label for="name">{{ __('Types biens') }}  <span class="text-danger">*</span></label>
                                    <select name="type_bien_id" id="_type_bien" required class="form-control">
                                        @foreach ($type_biens as $type_bien)
                                            <option  value="{{ $type_bien->id }}" {{ $type_bien->id == $bien->type_bien_id?'selected':'' }}>{{ $type_bien->name }}</option>
                                        @endforeach
            
                                    </select>
                                </div>
                                <div class="form-group  col-12 col-lg-6">
                                    <label for="name">{{ __('Types') }}  <span class="text-danger">*</span></label>
                                    <select name="type_id" id="_type" required class="form-control">
                                        @foreach ($types as $type)
                                            <option  value="{{ $type->id }}" {{ $type->id == $bien->type_id?'selected':'' }}>{{ $type->name }}</option>
                                        @endforeach
            
                                    </select>
                                </div>
                                <div class="form-group  col-12 col-lg-6">
                                    <label for="name">{{ __('Commune') }}  <span class="text-danger">*</span></label>
                                    <select name="commune_id" id="_commune" required class="form-control">
                                        @foreach ($communes as $commune)
                                            <option  value="{{ $commune->id }}" {{ $commune->id == $bien->commune_id?'selected':'' }}>{{ $commune->name }}</option>
                                        @endforeach
            
                                    </select>
                                </div>
                                {{-- <div class="form-group  col-12 col-lg-6">
                                    <label for="name">{{ __('Locations') }}</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">A louer</option>
                                        <option value="0">A vendre</option>
                                    </select>
                                </div> --}}
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
