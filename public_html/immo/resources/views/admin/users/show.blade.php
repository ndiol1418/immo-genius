@extends('layouts.admin')
@php
    // $collaborateur = $user->collaborateur;
@endphp

@section('title', "Profil collaborateur")

@section('content')
    {{-- Contenu de la page --}}
    @include('admin.users.fiche')
@endsection
