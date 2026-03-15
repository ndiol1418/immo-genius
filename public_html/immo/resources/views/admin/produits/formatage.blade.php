<?php
    use Carbon\Carbon;
    $data = [];
    $labels = [];
    $key_1 = 'reclamations';
    $key_2 = 'montant';
    $data['montant'] = [];
    $data['nombre'] = [];

    for ($i=11; $i >= 0 ; $i--) {
        $data_nok = true;
        $data_nok1 = true;
        //  code...
        $date = now()->subMonths($i);
        $labels[] = $date->isoFormat('MMMM Y');

        foreach ($produit->commandesByMonth() as $key => $years) {
            foreach ($years as $key => $month) {
                if((int) $key == (int)$date->format('m')){
                    $data['montant'][] = $month[0]->produit->prix_ht * $month->sum('quantite');
                    $data['nombre'][] = $month->sum('quantite');
                    $data_nok = false;
                }
            }
        }
        if($data_nok){
            $data['montant'][] = 0;
            $data['nombre'][] = 0;
        }
    }
?>

<div class="row">

    <div class="col-12 col-lg-8">
        <div class="row">
            <div class="col-12">
                <canvas id="myChart" style="width: 100% !important"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <table class="table table-sm table-striped">
            <tr class="bg-dark">
                <td>{{ __('general.mois') }}</td>
                <td class="text-right">{{ __('Montant HT') }}</td>
                <td class="text-right">{{ __('Quantite') }}</td>
            </tr>
            @for($i = 0; $i < count($data['nombre']); $i++)
                <tr>
                    <td class="text-uppercase">{{ $labels[$i] }}</td>
                    <td class="text-right">{{ number_format($data['montant'][$i],0,'',' ') }}</td>
                    <td class="text-right">{{ number_format($data['nombre'][$i],0,'',' ') }}</td>
                </tr>
            @endfor
        </table>
    </div>
</div>
@push('subScript')

<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

@include('partials.chart.line',[
    'data'=>$data,
    'labels'=>$labels,
    // 'title'=>"CA par filiale",
    'line_title_1'=>__("Quantite"),
    // 'line_title_2'=>'Nbre Commande mois precedent',
    // 'bar_title'=>'Commandes',
    'line_title'=>"Montants",
    'key_2'=>'nombre',
    'key_1'=>'montant',
    'bar_title_1'=> __("Montants"),
    // 'bar_title_2'=>'CA mois précédent',
    'id'=>'myChart'
])
@endpush

