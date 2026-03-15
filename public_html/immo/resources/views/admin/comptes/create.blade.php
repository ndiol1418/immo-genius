@extends('layouts.admin')
@section('title',"Ajout d'une filiale")

@section('actions')

    @include('partials.components.headTitlePageElement',['urlback'=>'','title'=>__('Retour')])

@endsection

@section('content')

    <div class="col-12">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="row">
                    <form method="POST" action="{{ route('admin.comptes.store') }}"  enctype="multipart/form-data" class="col-lg-8 col-12">

                        <div class="row">
                            @csrf
                            @include('admin.comptes.form',['access'=>true])
                            <div class="form-group col-md-6 mt-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Valider') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="col-12 col-lg-4 d-none d-sm-block">
                        <div class="bg-light p-2" style="height: 530px;border-radius:10px">
                            <h5 class="text-danger text-center">Informations</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
