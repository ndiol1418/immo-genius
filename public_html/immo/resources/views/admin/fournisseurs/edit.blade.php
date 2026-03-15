@extends('layouts.admin')
@section('title',__('fournisseur.title_edit'))
@section('subtitle', __('fournisseur.subtitle_edit'))

@section('content')
    {{-- Contenu de la page --}}
        <div class="col-md-12">
            <!-- Collapsable Card Example -->
            <div class="card  mb-4">
                <!-- Card Header - Accordion -->
                <!-- Card Content - Collapse -->
                <div class="content-form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                {{-- <div class="table-responsive"> --}}
                                    <form method="POST" action="{{ route($_espace.'.agents.update', $fournisseur->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @include('admin.fournisseurs.form')
                                        <div class="form-group row  mb-0">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('general.mis_a_jour') }}
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
