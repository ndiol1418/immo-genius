@extends('layouts.admin')
@section('title', 'Visualisation de la promotion')

@section('actions')
    @include('partials.components.headTitlePageElement', ['urlback' => '', 'title' => __('Retour')])
@endsection

@section('content')
    @include('admin.promotions.fiche')
@endsection
