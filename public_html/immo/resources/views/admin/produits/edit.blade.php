@extends('layouts.admin')
@section('title', 'Produits')
@section('subtitle', 'Modification du produit')>


@section('content')
<div class="col-md-12 mb-2">
        <form method="POST" action="{{ route('admin.produits.update', $produit->id) }}">
            @csrf
            @include('admin.produits.form')
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            @method('PATCH')
        </form>
</div>

@endsection
