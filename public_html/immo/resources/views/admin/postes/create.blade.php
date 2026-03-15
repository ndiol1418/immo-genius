@extends('layouts.admin')
@section('title','Postes')
@section('subtitle','Ajouter un Poste')

@section('content')
    {{-- Contenu de la page --}}
        <div class="col-md-12">
            <!-- Collapsable Card Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->

                <!-- Card Content - Collapse -->
                <div class="content-form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <form method="POST" action="{{ route('admin.postes.store') }}">
                                    @csrf

                                    @include('admin.postes.form')

                                    <div class="form-group row  mb-0">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Valider') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
        </div>
    {{-- Fin contenu --}}
@endsection

