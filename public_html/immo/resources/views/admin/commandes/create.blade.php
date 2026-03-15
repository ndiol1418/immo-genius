@extends('layouts.admin')
@section('title','commande.head_title')

@section('actions')
    @include('partials.components.headTitlePageElement',['urlback'=>''])
@endsection

@section('content')
<div class="col-md-12">
    <div class="card  mb-4">
        <div class="content-form">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7 mb-2">
                        <form method="POST" action="{{ route('commandes.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-7 col-12">
                                    @include('admin.commandes.form',['station'=>true])
                                </div>
                                <div class="col-12">
                                    <div id="listeProduits"></div>
                                </div>
                            </div>
                            <div class="form-group row  mb-0 mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" id="valider">
                                        {{ __('general.valider') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-5 col-12">
                        <div id="produits"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    @include('admin.commandes.script')
@endsection
