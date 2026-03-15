@extends('layouts.admin')
@section('title','Collaborateurs')
@section('subtitle','Ajouter un collaborateur')

@section('content')

    {{-- Contenu de la page --}}

        <div class="col-md-12">
            <!-- Collapsable Card Example -->
            <div class="card shadow-none mb-4">
                <!-- Card Header - Accordion -->
                <!-- Card Content - Collapse -->
                <div class="content-form">
                    <div class="card-body">
                        <div class="col-md-12 mb-2">
                            <form method="POST" action="{{ route('admin.users.store') }}"  enctype="multipart/form-data">
                                @csrf
                                @include('admin.users.form-edit')
                                <div class="form-group row  mb-0">
                                    <div class="col-md-12 mt-0 text-right">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('general.valider') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
        </div>

    {{-- Fin contenu --}}
@endsection
