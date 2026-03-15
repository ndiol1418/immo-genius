@include('components.stats.nombre',[
    'titre'=>__('fournisseur.produits'),
    'soustitre'=>__('fournisseur.tous'),
    'class'=>$col??'col-lg-3 col-sm-6 col-6',
    'nombre'=>count($datas['produits']),
    'icone'=>'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
    'url'=>'?produit'??false,
    'bg'=>$class??'bg-light'
])
@include('components.stats.nombre',[
    'titre'=>__('C.A'),
    'soustitre'=>__('fournisseur.year'),
    'class'=>$col??'col-lg-3 col-sm-6 col-6',
    'nombre'=>number_format($datas['ca'],0,'',' '),
    'icone'=>'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
    'url'=>'?ca'??false,
    'bg'=>$class??'bg-light'
])
@include('components.stats.nombre',[
    'titre'=>__('fournisseur.commandes'),
    'soustitre'=> __('fournisseur.en_cours'),
    'class'=>$col??'col-lg-3 col-sm-6 col-6',
    'nombre'=>count($datas['commandes_en_cours']),
    'icone'=>'<i class="nav-icon fas fa-store"></i>',
    'url'=>''??false,
    'bg'=>$class??'bg-light'
])
@include('components.stats.nombre',[
    'titre'=>__('fournisseur.commandes'),
    'soustitre'=>__('fournisseur.traites'),
    'class'=>$col??'col-lg-3 col-sm-6 col-6',
    'nombre'=>count($datas['commandes_traitees']),
    'icone'=>'<i class="nav-icon fas fa-store"></i>',
    'url'=>''??false,
    'bg'=>$class??'bg-light'
])
