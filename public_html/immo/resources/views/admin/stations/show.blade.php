@extends('layouts.admin')
@section('title',__('boutique.title_visualisation'))
<style>
    #map { height: 221px}
    h4 {
      width: 70%;
      margin: .7em auto;
      overflow: hidden;
      text-align: center;
      font-weight:300;
      color: #adb4bc !important;
      font-size: 18px;
    }
    h4:before, h4:after {
      content: "";
      display: inline-block;
      width: 50%;
      margin: 2px .5em 0 -55%;
      vertical-align: middle;
      border-bottom: 1px solid;
      color: #ddd
    }
    h4:after {
      margin: 2px -55% 0 .5em;
    }
    /* span {
      display: inline-block;
      vertical-align: middle;
    } */
</style>
<?php
    use Carbon\Carbon;
    use App\Models\Document;

    $date12MonthsAgo = Carbon::now()->subMonths(12);

    $somme = 0;
    $nombre = 0;
    $data = [];
    $labels = [];
    $line_key_1 = 'nombre';
    $line_key_2 = 'nombre2';
    $key_1 = 'nombre';
    $key_2 = 'index_init';
    $array_data['montant'] = [];
    $array_data['nombre'] = [];
    $array_data['mois'] = [];

    for ($i=1; $i <= 12 ; $i++){
        $data_nok = true;
        $data_nok1 = true;
        $fournisseur_nok = true;
        $fournisseur_nok1 = true;
        $date = now()->month($i);
        // $date = now()->subMonths($i);

        $labels[] = $date->isoFormat('MMMM');
        $mois = $date->format('m');
        if (count($commandes)>0) {
            # code...

            foreach ($commandes as $k => $commande) {
                foreach ($commande as $key => $item) {
                    $tmp = 0;
                    $cpt = 0;
                    if((int)$key == (int)$mois){
                        $array_data['mois'][]       = (int)$mois ;
                        $data_nok  = false;
                        $array_data['montant'][]     = $item->sum('montant_ht');;
                        $array_data['nombre'][]     = count($item);
                    }
                }
            }
        }
        if($data_nok){
            $array_data['nombre'][]   = 0;
            $array_data['mois'][]     = 0;
            $array_data['montant'][]     = 0;
        }


    }

?>
@section('content')

    <div class="col-12">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="card shadow-none mb-4">
                    <div class="content-form">
                        <div class="card-body">
                            <div class="tab-content profil_infos px-2" id="myTabContent">
                                <div class="tab-pane fade show active" id="compte" role="tabpanel"
                                    aria-labelledby="compte-tab">
                                    <div class="profile-work">

                                        @include('components.title-separe',[
                                            'title'=>__('boutique.infos'),
                                            'class'=>'text-muted mb-2'
                                        ])
                                        <div class="tab-content profil_infos" id="myTabContent">
                                            <div class="tab-pane fade show active" id="compte" role="tabpanel"
                                                aria-labelledby="compte-tab">
                                                <div class="row">
                                                    @include('components.affichage',[
                                                        'title'=>__('boutique.nom'),
                                                        'value'=>$station->nom,
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])
                                                    @include('components.affichage',[
                                                        'title'=>__('boutique.adresse'),
                                                        'value'=>$station->adresse,
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])
                                                    @include('components.affichage',[
                                                        'title'=>__('boutique.email'),
                                                        'value'=>$station->user?$station->user->email:'',
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])
                                                    @include('components.affichage',[
                                                        'title'=>__('boutique.code'),
                                                        'value'=>$station->code,
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])
                                                    @include('components.affichage',[
                                                        'title'=>__('boutique.zone'),
                                                        'value'=>$station->zone->nom,
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])
                                                    @include('components.affichage',[
                                                        'title'=>__('boutique.gammes'),
                                                        'value'=>$station->view_gammes,
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div id="map"></div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="row p-2">
                    @include('components.title-separe',[
                        'title'=>__('boutique.statistique'),
                        'class'=>'text-muted mb-2'
                    ])
                    @include('components.dashboard.card-info',[
                        'title'=>__('boutique.ca'),
                        'subtitle'=>__('boutique.annee_encours'),
                        'class'=>'col-lg-3 col-sm-6 col-6',
                        'nbre'=>$ca,
                        'icon'=>$data['icon']??'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                        'route'=>$data['route']??false,
                        'param'=>$station->compte->devise->libelle,
                        'key'=>$data['key']??'',
                    ])
                    @include('components.dashboard.card-info',[
                        'title'=>__("boutique.ca"),
                        'subtitle'=>__('boutique.ca_mois_en_cours'),
                        'class'=>'col-lg-3 col-sm-6 col-6',
                        'nbre'=>$ca_mois_en_cours,
                        'icon'=>$data['icon']??'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                        'route'=>$data['route']??false,
                        'param'=>$station->compte->devise->libelle,
                        'key'=>$data['key']??'',
                    ])
                    @include('components.dashboard.card-info',[
                        'title'=>__("boutique.ca"),
                        'subtitle'=>__('boutique.mois_precedent'),
                        'class'=>'col-lg-3 col-sm-6 col-6',
                        'nbre'=>$ca_mois_precedent,
                        'icon'=>$data['icon']??'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                        'route'=>$data['route']??false,
                        'param'=>$station->compte->devise->libelle,
                        'key'=>$data['key']??'',
                    ])
                    @include('components.dashboard.card-info',[
                        'title'=>__("boutique.commandes"),
                        'subtitle'=>__('boutique.commandes_encours'),
                        'class'=>'col-lg-3 col-sm-6 col-6',
                        'nbre'=>$commandes_en_cours->count(),
                        'icon'=>$data['icon']??'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                        'route'=>$data['route']??false,
                        'param'=>'',
                        'key'=>$data['key']??'',
                    ])
                </div>

            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <canvas id="myChart"></canvas>
                    </div>
                    <div class="col-12 col-lg-4">
                        @include('admin.stations.recapTable')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scriptBottom')
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <script>
            (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
            ({key: "AIzaSyCaSfdQyOwQoWtaDwtL5AMOm3eA492dg9M", v: "weekly"});
            </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
        @include('admin.stations.marker')

        @include('partials.chart.line',[
            'data'=>$array_data,
            'labels'=>$labels,
            // 'title'=>"CA par filiale",
            'line_title_1'=>__("fournisseur.chart_title_line"),
            // 'line_title_2'=>'Nbre Commande mois precedent',
            'bar_title'=>'Commandes',
            'line_title'=>"Chiffre d'affaires",
            'key_2'=>'nombre',
            'key_1'=>'montant',
            'bar_title_1'=> __("fournisseur.chart_title"),
            // 'bar_title_2'=>'CA mois précédent',
            'id'=>'myChart'
        ])
        {{-- <script>
            window.history.forward();
            function noBack() { window.history.forward(); }
        </script> --}}
    @endsection
@endsection
