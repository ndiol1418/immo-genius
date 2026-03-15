<div class="card shadow-none mt-2">
    <div class="card-header ui-sortable-handle">
        <h6 class="card-title">
            {{-- <i class="fa fa-eye mr-1"></i> --}}
            {{ __('Tableau des commandes') }} <br>
            <span class="subtitle text-primary">sur les 12 derniers mois</span>

        </h6>
    </div>
    <div class="card-body" style="height: 408px;overflow:auto">
        <style>
            .table th, .table td {
                    padding: 3px 5px !important;
            }
        </style>
        <table class="table table-condensed table-striped table-bordered">
            <thead class="bg-dark">
                <tr>
                    <td>Mois</td>
                    <td>Montant</td>
                    <td>Nombre</td>
                </tr>
            </thead>
            <tbody>
                {{-- {{ dd($array_data) }} --}}
                @if(count($array_data))
                    @foreach ($array_data['montant'] as $k => $v)
                        <tr>
                            <td class="text-sm">{{ $labels[$k] }}</td>
                            <td class="text-sm">{{ number_format($v,0,'',' ') }} {{ $_devise }}</td>
                            <td class="text-sm">{{ number_format($array_data['nombre'][$k],0,'',' ') }} </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
