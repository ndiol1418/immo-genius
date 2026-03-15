@include('components.affichage',[
    'title'=>__('produit.prix_vente_ht'),
    'value'=>number_format($produit->prix_vente_ht,0,'',' '),
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.prix_vente_ttc'),
    'value'=>number_format($produit->prix_vente_ttc,0,'',' '),
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.tva_vente'),
    'value'=>number_format($produit->tva_vente,0,'',' '),
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
