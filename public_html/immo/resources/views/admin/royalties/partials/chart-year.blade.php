<?php
    use Carbon\Carbon;
    $somme = 0;
    $nombre = 0;
    $data_ca = [];
    $labels = [];
    $line_key_1 = 'nbr_1';
    $line_key_2 = 'nombre2';
    $key_1 = 'nombre';
    $key_2 = 'nbr_2';
    $data_ca = [];
        foreach ($chiffre_affaires as $k => $chiffre_affaire) {
            $labels[] = $k;
            # code...
            $montant = $chiffre_affaire->sum('montant_ht');
            $created = Carbon::create($chiffre_affaire[0]->commande_date);
            if(((int) $created->format('Y') == (int)$k)){
                // $labels[]       = $created->isoFormat('MMMM');
                $data_ca['montant'][]     = $montant;
                $data_ca['taux'][]     = $chiffre_affaire->sum(function($q){
                                                    return ($q->montant_ht*($q->taux_royalties??1)/100);
                                                });
                $data_ca['nombre'][]     = count($chiffre_affaire) ;
            }
        }

?>
<div class="row">

    <div class="{{ 'col-12' }}">
        <canvas id="myChart{{ $j }}"></canvas>
    </div>
</div>

{{-- {{ dd($data_ca) }} --}}
@push('subScript')
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    @include('partials.chart.line',[
        'data'=>$data_ca,
        'labels'=>$labels,
        // 'title'=>"CA par filiale",
        'line_title_1'=>__("boutique.commandes"),
        // 'line_title_2'=>'Nbre Commande mois precedent',
        'bar_title'=>__("boutique.ca"),
        'line_title'=>__("general.taux_royalties"),
        'key_2'=>'nombre',
        'key_3'=>'taux',
        'key_1'=>'montant',
        'bar_title_2'=> __("general.taux_royalties"),
        'bar_title_1'=>__('boutique.ca'),
        'id'=>'myChart'.$j.'',

    ])
@endpush
