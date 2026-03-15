@extends('layouts.admin')
@section('title', 'Visualisation du produit')

@section('actions')
<div class="d-flex justify-content-end">

    <a href="{{ route('admin.produits.edit', $produit->id) }}" class="btn btn-primary btn-xs mr-2">
        <i class="fa fa-edit"></i> Modifier
    </a>
    @if($_user->profil == 'admin')
    <form method="post" action="{{ route('admin.produits.toggle', $produit->id) }}" style="display: inline-block;" class="d-none d-sm-block mr-2" >
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-xs {{ $produit->statut ? 'bg-success' : 'bg-danger' }} me-2" onclick="return confirm('{{ $produit->statut ? 'Voulez-vous vraiment désactiver ce produit ?' : 'Voulez-vous vraiment activer ce produit ?' }}');">
            <i class="fa fa-{{ $produit->statut ? 'lock' : 'unlock' }}"></i>
        </button>
    </form>
@endif

        @include('partials.components.headTitlePageElement', ['urlback' => ''])
</div>
@endsection

{{-- @section('actions')
    <div class="d-flex justify-content-end">

        <a href="{{ route('admin.fournisseurs.edit', $fournisseur->id)  }}" class="btn btn-primary btn-xs mr-2">
            <i class="fa fa-edit"></i> Editer
        </a>
        @if ($fournisseur->etat)
            @include('partials.components.deleteBtnElement',[
                'url'=>route('admin.fournisseurs.destroy',$fournisseur->id),
                'class'=> 'btn btn-xs btn-warning mr-2',
                'message_confirmation'=>"Voulez-vous vraiment désactiver le fournisseur : " .$fournisseur->nom,
                'entity'=>$fournisseur,
                'btnInnerHTML'=>'<i class="fa fa-unlock"></i>'
            ])
        @else
            @include('partials.components.deleteBtnElement',[
                'url'=>route('admin.fournisseurs.destroy',$fournisseur->id),
                'class'=> 'btn btn-sm btn-danger mr-2',
                'message_confirmation'=>"Voulez-vous vraiment activer le fournisseur : " .$fournisseur->nom,
                'entity'=>$fournisseur,
                'btnInnerHTML'=>'<i class="fa fa-lock"></i>'
            ])
        @endif
        @include('partials.components.headTitlePageElement',['urlback'=>'','title'=>__('Retour')])

    </div>
@endsection --}}

@section('content')
<div class="col-12 col-md-12">
    <div class="card shadow-none">
        <div class="card-body">
            @include('components.title-separe',[
                'title'=>'Informations Générales',
                'class'=>'text-muted'
            ])
            <div class="row">
                @include('admin.produits.fiches.generale')
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="card shadow-none">
        <div class="card-body">
            @include('components.title-separe',[
                'title'=>"Informations d'achats",
                'class'=>'text-muted'
            ])
            <div class="row">
                @include('admin.produits.fiches.achats')
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="card shadow-none">
        <div class="card-body">
            @include('components.title-separe',[
                'title'=>"Informations de ventes",
                'class'=>'text-muted'
            ])
            <div class="row">
                @include('admin.produits.fiches.ventes')
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-md-12">
    <div class="card shadow-none">
        <div class="card-body">
            @include('components.title-separe',[
                'title'=>__('Commandes par mois'),
                'class'=>'text-muted'
            ])

            @include('admin.produits.formatage')
        </div>
    </div>
</div>
@endsection


@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
