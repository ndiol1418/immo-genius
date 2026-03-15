@include('components.affichage',[
    'title'=>__('produit.prix_unitaire_ht'),
    'value'=>number_format($produit->prix_unitaire_ht,0,'',' '),
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.prix_ht'),
    'value'=>number_format($produit->prix_ht,0,'',' '),
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
@include('components.affichage',[
    'title'=>__('produit.prix_ttc'),
    'value'=>number_format($produit->prix_ttc,0,'',' '),
    'style'=>1,
    'col'=>'col-12 col-lg-4'
])
