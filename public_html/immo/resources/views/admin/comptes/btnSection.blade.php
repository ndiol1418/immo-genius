<div class="col-12 col-lg-12">

    <button type="button" href="" class="btn btn-xs btn-warning editBtn mr-2" data-toggle="modal" data-target="#exampleModal">
        <i class="fa fa-edit"></i> Edition du compte
    </button>
    @if ($compte->status)
        @include('partials.components.deleteBtnElement',[
            'url'=>route('admin.comptes.destroy',$compte->id),
            'class'=> 'btn btn-xs btn-success text-dark',
            'message_confirmation'=>"Voulez-vous vraiment désactiver le compte : " .$compte->nom_complet,
            'entity'=>$compte,
            'btnInnerHTML'=>'<i class="fa fa-unlock"></i> Désactiver le compte ?'
        ])
        @else

        @include('partials.components.deleteBtnElement',[
            'url'=>route('admin.comptes.destroy',$compte->id),
            'class'=> 'btn btn-xs btn-danger',
            'message_confirmation'=>"Voulez-vous vraiment activer le compte : " .$compte->nom_complet,
            'entity'=>$compte,
            'btnInnerHTML'=>'<i class="fa fa-lock"></i> Activer le compte ?'
        ])
    @endif

</div>
