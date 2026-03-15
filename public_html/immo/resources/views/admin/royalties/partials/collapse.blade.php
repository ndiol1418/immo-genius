<div class="card">
    <div class="card-header py-0 px-2" id="{{ $id }}">
    <h2 class="mb-0 p-0 d-flex justify-content-between align-items-center">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $id }}" aria-expanded="true" aria-controls="collapse-{{ $id }}">
           <strong>{{ __('general.annee') }} {{ $name }}</strong>
        </button>
        <div class="text-right d-flex">
            <select name="" id="" class="forn-control form-control-sm" style="width: 70px;height: 24px;font-size: 10px;"
                onchange='window.open( "{{route("royalties.periodique")}}/"  + this.options[ this.selectedIndex ].value );'>
                @foreach ($groupsByYears as $k=>$val)
                    <option value="{{ $k }}"  {{ $k == $param ? 'selected'  : ''}}>{{ $k }}</option>
                @endforeach
            </select>
        </div>
    </h2>
    </div>

    <div id="{{ 'collapse-'.$id }}" class="collapse {{ $i == 0 ?'show':'' }}" aria-labelledby="{{ $id }}" data-parent="#accordionExample">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-6">
                <table class="table table-borderless table-sm table-striped border-0">
                    <thead>
                        <tr class="bg-dark">
                            <td>{{ __('general.month') }}</td>
                            <td class="text-center">{{ __('boutique.commande') }}</td>
                            <td>{{ __('boutique.ca') }}</td>
                            <td>{{ __('menu.taux_royalties') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($year as $k=> $commandes)
                            <tr>
                                <td class="text-uppercase">{{ $k }}</td>
                                <td class="text-center">{{ number_format($commandes->count(),0,'',' ') }}</td>
                                <td>{{ number_format($commandes->sum('montant_ht'),0,'',' ') }}</td>
                                <td>{{ number_format($commandes->sum(function($q){
                                    return ($q->montant_ht*($q->taux_royalties??1)/100);
                                }),0,'',' ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    @include('admin.royalties.partials.chart',[
                        'chiffre_affaires'=>$year,
                        'j'=>$i
                    ])
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
