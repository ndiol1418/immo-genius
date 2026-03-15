
@foreach ($comptes as $compte)
    @include('components.dashboard.card-info',[
        'title'=>$compte->libelle,
        'class'=>count($comptes) <= 3 ? 'col-lg-4 col-sm-4 col-12' : 'col-lg-3 col-sm-4 col-12',
        'icon'=>'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
        'style'=>true,
        'route'=>'superviseurs.comptes.show',
        'key'=>$compte->id,
        'datas'=>[
            'fournisseurs'=>$compte->fournisseurs,
            'commandes'=>
                [
                    0=>[
                            'title'=>'CA mois en cours',
                            'nbre'=>$compte->CaMoisEnCours,
                            'color'=>"#e74c3c",
                            'param'=>$compte->devise->libelle
                    ],
                    1=>[
                            'title'=>'CA mois précédent',
                            'nbre'=>$compte->CaMoisPrecedent,
                            'color'=>"#3498db",
                            'param'=>$compte->devise->libelle
                    ],
                    2=>[
                            'title'=>'Boutiques',
                            'nbre'=>$compte->stations->count(),
                            'color'=>"#09ce61",
                            'param'=>''
                    ],
                ]
            ]
    ])
@endforeach
