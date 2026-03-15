@extends('layouts.admin')
@section('title',"Modification de l'utilisateur")
@section('subtitle','Modification du collaborateur')

@section('content')
    <div class="col-md-12">
        <div class="card shadow-none mb-4">
            <div class="content-form">
                <div class="card-body">
                    {{-- <div class="row"> --}}
                        <div class="col-md-12 mb-2">
                            {{-- <div class="table-responsive"> --}}
                                <form method="POST" action="{{ route('users.update',$user->id )}}" enctype="multipart/form-data">
                                    @csrf

                                    @method('PATCH')
                                    @if($_user->fournisseur)
                                        @include('admin.fournisseurs.edit',['fournisseur'=>$_user->fournisseur])
                                    @endif
                                    @if($_user->role->profil_id == 1)
                                    @include('admin.users.form-edit')
                                        
                                    @endif

                                    <div class="form-group row  mb-0">

                                        <div class="col-md-9 float-right">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('general.valider') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            {{-- </div> --}}
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
            <!--  -->
        </div>
    </div>
@endsection
