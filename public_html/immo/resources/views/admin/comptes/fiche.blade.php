@include('components.affichage',[
    'title'=>'Libellé',
    'value'=>$compte->libelle,
    'style'=>1
])

@include('components.affichage',[
    'title'=>'Adresse Email',
    'value'=>$compte->email,
    'style'=>1,
    'col'=>'col-lg-6 col-12'
])
@include('components.affichage',[
    'title'=>'Téléphone',
    'value'=>$compte->telephone,
    'style'=>1,
    'col'=>'col-lg-6 col-12'
])
@include('components.affichage',[
    'title'=>'Adresse',
    'value'=>$compte->adresse,
    'style'=>1
])
@include('components.affichage',[
    'title'=>'Pays',
    'value'=>$compte->pays,
    'style'=>1,
    'col'=>'col-lg-6 col-12'
])
@include('components.affichage',[
    'title'=>'Devise',
    'value'=>$compte->devise->libelle,
    'style'=>1,
    'col'=>'col-lg-6 col-12'
])
