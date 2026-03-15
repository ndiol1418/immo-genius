
@extends('layouts.admin')

@section('title')
{{ __('general.collaborateurs') }}
@endsection

@section('actions')
    @include('partials.components.modalElement',['title'=>'Import csv','route'=>'admin.importUsersCsv','key'=>'collab'])
    <div class="row">
        <div class="col-12">
            @include('partials.components.headTitlePageElement',['url'=>'admin/users/create'])
        </div>
    </div>

@endsection

@section('content')
    @if($_espace == 'agent') @include('admin.users.fournisseur.liste') @endif
    @if($_espace == 'admin') @include('admin.users.liste') @endif
    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable')

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElementUser', ['id' => 'datatable'])
    <script>
        $('.delete-user').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm('Voulez vous vraiment supprimer cet collaborateur?')) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
