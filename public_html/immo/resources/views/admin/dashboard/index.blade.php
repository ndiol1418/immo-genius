@extends('layouts.admin')

@section('title','Tableau de bord')

@section('actions')

@endsection

@section('content')


@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
