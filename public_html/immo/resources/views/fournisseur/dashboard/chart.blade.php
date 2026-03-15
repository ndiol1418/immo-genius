<div class="card shadow-none">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-8">
                <canvas id="myChart"></canvas>
            </div>
            <div class="col-12 col-lg-4">
                <table class="table table-sm table-condensed table-striped">
                    <thead class="bg-dark">
                        <tr>
                            <td>{{ __('fournisseur.mois') }}</td>
                            <td class="text-right">{{ __('fournisseur.operations') }}</td>
                            <td class="text-right">{{ __('fournisseur.montant') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($data_ca['montant'])>0)
                            @for ($i = 0; $i < count($data_ca['montant']); $i++)
                                <tr>
                                    <td>{{ $labels[$i] }}</td>
                                    <td class="text-right">{{ $data_ca['nombre'][$i] }}</td>
                                    <td class="text-right">{{ number_format($data_ca['montant'][$i],0,'',' ') }}</td>
                                </tr>
                            @endfor
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
