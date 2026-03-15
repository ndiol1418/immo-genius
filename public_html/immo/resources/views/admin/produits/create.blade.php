@extends('layouts.admin')
@section('title', "Ajout d'un produit")
@section('subtitle', 'Ajouter un produit')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    .required-label {
        position: relative;
    }

    .required-label::after {
        content: "*";
        color: red;
        position: absolute;
        top: 0;
        right: -10px;
    }
</style>

@section('content')
    <div class="col-12 ml-2">
        <form action="{{ route('admin.produits.store') }}" method="POST">
            @csrf
            @include('admin.produits.form')
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection
