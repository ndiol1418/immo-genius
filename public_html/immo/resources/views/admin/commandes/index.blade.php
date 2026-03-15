@extends('layouts.admin')
@section('title','commande.head_title')

@section('actions')
    @include('partials.components.headTitlePageElement',['url'=>'commandes/create'])
@endsection

@section('content')

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>

    </script>
@endsection
