@extends('layouts.admin')
@section('title', "Mon Profil")
@php
    $user = $_user;
@endphp
@section('actions')
    {{-- @if (env('Gestion_user')) --}}
        @if (Auth::user()->id == $user->id)
            <a href="{{ route($_espace.'.users.edit',$user->id) }}" class="btn btn-primary btn-xs" style="color:white !important">
                <i class="fa fa-edit"></i> Editer
            </a>
        @endif
    {{-- @endif --}}
@endsection
@section('content')
    {{-- Contenu de la page --}}
    @include('admin.users.fiche')
@endsection
