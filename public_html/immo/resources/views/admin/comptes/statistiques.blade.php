<?php
    use Carbon\Carbon;
    $somme = 0;
    $nombre = 0;
    $data_ca = [];
    $labels = [];
    $line_key_1 = 'nombre';
    $line_key_2 = 'nombre2';
    $key_1 = 'nbr_1';
    $key_2 = 'nbr_2';
    $year = $today->format('Y');
    $month = $today->isoFormat('MMMM');
    $data_ca = [];
    for ($i=1; $i <= 12 ; $i++){
        $data_nok = true;
        $data_nok1 = true;
        $date = now()->month($i);
        $labels[] = $date->isoFormat('MMMM');
        $mois = $date->format('m');
        $commandeCurrentYear = $compte->currentCommandesYear($year);
        foreach ($commandeCurrentYear as $k => $commande) {
                # code...
            $montant = $commande->sum('montant_ht');
            if(((int) $k == (int)$mois)){
                $created = Carbon::create($commande[0]->commande_date);
                // $labels[]       = $created->isoFormat('MMMM');
                $data_ca['montant'][]     = $montant;
                // $data[$k][$mois]     = (int)$mois ;
                $data_nok           = false;
            }

        }

        if($data_nok){
                // $data['index_init'][] = 0;
                $data_ca['montant'][]   = 0;
                // $data[$k][]     = 0;
                // $data['nature'][]   = [0,0,0,0];
        }
    }
    $fournisseurs = $compte->fournisseurs()->get();
    $dataSourceFournisseur = [];
    $i=0;
    foreach ($fournisseurs as $key => $fournisseur) {
        $ca = $fournisseur->getcaByYear($year);
        if($ca > 0){
            $dataSourceFournisseur[$i]['label'] = $fournisseur->nom;
            $dataSourceFournisseur[$i]['value'] = number_format($ca,0,'','');
            $i++;
        }
    }
?>
@extends(isset($screen)?'layouts.admin':'layouts.superviseur')
@section('title',"Visualisation de la filiale ".$compte->libelle)
@section('actions')

    <label for="year" class="my-0 {{ isset($screen)&& $screen?'d-none':'' }}">
        Choisir une année :
        <select name="year" id="year" onchange='
            window.open( "{{route("superviseurs.comptes.annuelles",$compte->id)}}/"  + this.options[ this.selectedIndex ].value,"_self" );
            ' class="">
            <option disabled selected>Année</option>
            @isset($_years)
                @foreach($_years as $key => $value)
                    <option value="{{ $value }}" {{ $today->year == $value ? "selected" : ''}}>{{ $value }}</option>
                @endforeach
            @endisset
        </select>
    </label>
@endsection
@section('content')
    <div class="col-12 col-md-6 {{ isset($screen)&& $screen?'d-none':'' }}">
        <div class="card shadow-none">
            <div class="card-body pt-0">
                <div class="row">
                    <div class="tab-content profil_infos px-2" id="myTabContent">
                        <div class="tab-pane fade show active" id="compte" role="tabpanel"
                            aria-labelledby="compte-tab">
                            <div class="profile-work">

                                {{-- @include('components.tab_title',[
                                    'title'=>"Information de la filiale",
                                    'class'=>'bg-primary'
                                ]) --}}
                                @include('components.title-separe',[
                                    'title'=>'Informations de la filiale',
                                    'class'=>'text-muted mb-0'
                                ])
                                <div class="tab-content profil_infos" id="myTabContent">
                                    <div class="tab-pane fade show active" id="compte" role="tabpanel"
                                        aria-labelledby="compte-tab">

                                        @if (isset($compte))
                                            <div class="row">
                                                @include('admin.comptes.fiche')
                                            </div>
                                        @else
                                            Aucune Information de la filiale
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="{{ isset($screen)&& $screen?'col-12':'col-12 col-md-6' }}">
        <div class="card-body pt-0">
            <div class="row">
            {{-- Dashbord --}}
                @include('components.title-separe',[
                    'title'=>'Informations Globales',
                    'class'=>'text-muted'
                ])
                @include('admin.comptes.card',[
                    'datas'=>$datas
                ])
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card-body pt-0">
            <div class="row">
                @include('components.title-separe',[
                    'title'=>'Commandes du mois en cours: '.$month.'',
                    'class'=>'text-muted'
                ])
                @include('admin.comptes.card',[
                    'datas'=>$commandes,
                ])
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card-body pt-0">
            <div class="row">
                @include('components.title-separe',[
                    'title'=>'Situation du mois précédent',
                    'class'=>'text-muted'
                ])
                @include('admin.comptes.card',[
                    'datas'=>$mois_precedent
                ])
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card-body pt-0">
            <div class="row">
                @include('components.title-separe',[
                    'title'=>"CA HT de l'année en cours",
                    'class'=>'text-muted'
                ])
                <div class="col-12">
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <canvas id="myChart" style="height: 330px !important;width:100% !important;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card-body pt-0">
            <div class="row">
                @include('components.title-separe',[
                    'title'=>"CA HT par fournisseur de l'année",
                    'class'=>'text-muted'
                ])
                <div class="col-12">
                    <div class="card shadow-none" style="height: 383px">
                        <div class="card-body chart-responsive d-flex justify-content-center align-items-center">
                            <div class="chart" id="myfirstchart" style="height: 300px;width:300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptBottom')
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        "use strict";
        var dataSource = @json($dataSourceFournisseur);
        var donut = new Morris.Donut({
            element: 'myfirstchart',
            resize: true,
            colors: ["#32331D","#84815B","#E200CB","#C03000","#000000","#3c8dbc", "#01a75a", "#f56954", "#00a65a","#FF0000","#2D241E","#985717","#AD4F09","#00FF00","#8E3557","#ADCF4F","#4BB5C1","#7FC6BC"],
            data: dataSource,
            xkey: 0,
            ykeys:0,
            // labels: ['Value'],
            hideHover: 'auto',
            formater: function (y, data) { return '$' + 1 }
        });
        var texte = $('text');
        texte[0].setAttribute('y',0)
        texte[1].setAttribute('y',10)
    </script>

    @include('components.fragmentJs',['url'=>route('partials.getCards'),"id"=>'wait'])
    @include('partials.chart.line',[
        'data'=>$data_ca,
        'labels'=>$labels,
        // 'title'=>"CA par filiale",
        // 'line_title_1'=>'Nbre Commande mois en cours',
        // 'line_title_2'=>'Nbre Commande mois precedent',
        // 'bar_title'=>'Commandes',
        'line_title'=>"Chiffre d'affaires",
        // 'key_2'=>'ca_mois_precedent',
        'key_1'=>'montant',
        'bar_title_1'=>"CA de l'année $year",
        // 'bar_title_2'=>'CA mois précédent',
        'id'=>'myChart',
        // 'height'=>'10000'
    ])
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
