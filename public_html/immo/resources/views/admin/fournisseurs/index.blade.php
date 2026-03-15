@php
    $nbre_fournisseurs = __('fournisseur.title_list');
@endphp
@extends('layouts.admin')
@section('title',$nbre_fournisseurs)

@section('actions')
    <div class="d-flex justify-content-end">
        @include('partials.components.headTitlePageElement',['url'=>$_espace.'/agents/create']) &nbsp;
    </div>
@endsection

@section('content')
    @include('partials.components.fournisseurs.liste')
@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>
        $('.delete-fournisseur').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm(<?php echo json_encode(__('fournisseur.alert')); ?>)) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
