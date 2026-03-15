
@extends('layouts.admin')
@section('title',__('Nouveau Agent'))
@section('subtitle', __('fournisseur.subtitle_edit'))

@section('actions')
    @include('partials.components.headTitlePageElement',['urlback'=>'','title'=>__('Retour')])
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card  mb-4">
            <div class="content-form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <form method="POST" action="{{ route($_espace.'.agents.store') }}">
                                @csrf
                                @include('admin.fournisseurs.form')
                                <div class="form-group row  mb-0">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('general.valider') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




