@extends('layouts.admin')

@section('title', __('fournisseur.fiche'))


@section('actions')
    <div class="d-flex justify-content-end align-items-center">
        @can('view',$fournisseur)
            
            <a href="{{ route($_espace.'.agents.edit', $fournisseur->id)  }}" class="btn btn-xs btn-primary mr-2">
                <i class="fa fa-edit"></i> Editer
            </a>
            @if ($fournisseur->status)
                @include('partials.components.deleteBtnElement',[
                    'url'=>route($_espace.'.agents.destroy',$fournisseur->id),
                    'class'=> 'btn btn-xs btn-warning mr-2',
                    'message_confirmation'=>"Voulez-vous vraiment désactiver le fournisseur : " .$fournisseur->nom,
                    'entity'=>$fournisseur,
                    'btnInnerHTML'=>'<i class="fa fa-unlock"></i> Activer'
                ])
            @else
                @include('partials.components.deleteBtnElement',[
                    'url'=>route($_espace.'.agents.destroy',$fournisseur->id),
                    'class'=> 'btn btn-xs btn-danger mr-2',
                    'message_confirmation'=>"Voulez-vous vraiment activer le fournisseur : " .$fournisseur->nom,
                    'entity'=>$fournisseur,
                    'btnInnerHTML'=>'<i class="fa fa-lock"></i> Desactiver'
                ])
            @endif
        @endcan
        @include('partials.components.headTitlePageElement',['urlback'=>'','title'=>__('Retour')])

    </div>
@endsection

@section('content')
    <div class="col-12 col-lg-7">
        @include('partials.components.fournisseurs.fiche')
    </div>
    @if (isset($_GET['produit']) && count($produits)>0)
        <div class="col-12">
            @include('admin.fournisseurs.liste_produit')
        </div>
    @endif
@endsection
@section('scriptBottom')
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    {{-- @include('partials.chart.line',[
        'data'=>$data_ca,
        'labels'=>$labels,
        'line_title_1'=>__("fournisseur.chart_title_line"),
        'line_title'=>"Chiffre d'affaires",
        'key_2'=>'nombre',
        'key_1'=>'montant',
        'bar_title_1'=> __("fournisseur.chart_title"),
        'id'=>'myChart'
    ]) --}}
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
