@include('components.affichage',[
    'title'=>__('produit.designation'),
    'value'=>$produit->designation,
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.designation_longue'),
    'value'=>$produit->designation_longue,
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.code_barre'),
    'value'=>$produit->codebarre,
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.code_barre_pcb'),
    'value'=>$produit->code_barre_pcb??'---',
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.famille'),
    'value'=>$produit->famille?$produit->famille->libelle:'---',
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.sous_famille'),
    'value'=>$produit->sous_famille?$produit->sous_famille->libelle:'---',
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.fournisseur'),
    'value'=>$produit->fournisseur?$produit->fournisseur->nom:'',
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.gamme'),
    'value'=>$produit->gamme?$produit->gamme->nom:'---',
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.colisage'),
    'value'=>$produit->colisage??'',
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])

