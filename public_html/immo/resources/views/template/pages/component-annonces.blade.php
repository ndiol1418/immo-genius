@foreach ($annonces as $i=>$annonce)
    @include('template.components.c_annonce_2',[
        'montant'=> $annonce->prix,
        'col'=>$col??'col-lg-6 col-sm-4 col-12',
        'i'=>$i,
        'id'=>$i,
        'param'=>'CFA',
        'titre'=>$annonce->immo->name,
        'adresse'=>$annonce->commune?($annonce->adresse??'---').', '.$annonce->commune->name.', '.$annonce->commune->departement->name:$annonce->adresse

    ])
@endforeach