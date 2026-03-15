<div class="card shadow-none mt-2">
    <div class="card-header ui-sortable-handle">
        <h6 class="card-title">
            {{-- <i class="fa fa-eye mr-1"></i> --}}
            {{ __('Immobilisations') }} <br>
            <span class="subtitle text-primary">Liste des immobilisations</span>

        </h6>
    </div>
    <div class="card-body" style="height: 408px;overflow:auto">
        <style>
            .table th, .table td {
                    padding: 3px 5px !important;
            }
        </style>
        <table class="table table-condensed table-striped table-bordered" id="datatable">
            <thead class="bg-dark">
                <tr>
                    <td>Libelle</td>
                    <td>Montant</td>
                </tr>
            </thead>
            <tbody>
                {{-- {{ dd($array_data) }} --}}
                @if(count($bien->immos))
                    @foreach ($bien->immos as $k => $immo)
                        <tr>
                            <td class="text-sm">{{ $immo->name }}</td>
                            <td class="text-sm">{{ number_format($immo->montant,0,'',' ') }} {{ $_devise??'CFA' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
