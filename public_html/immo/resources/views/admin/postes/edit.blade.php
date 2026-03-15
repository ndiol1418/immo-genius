@extends('layouts.admin')
@section('title','Postes')
@section('subtitle','Modification Poste')

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
                                {{-- <div class="table-responsive"> --}}
                                    <form method="POST" action="{{ route('admin.postes.update', $poste->id) }}">
                                        @csrf

                                        @include('admin.postes.form_edit')

                                        <div class="form-group row  mb-0">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Mettre à jour') }}
                                                </button>
                                            </div>
                                        </div>
                                        @method('PATCH')
                                    </form>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
        </div>
    {{-- Fin contenu --}}
@endsection
