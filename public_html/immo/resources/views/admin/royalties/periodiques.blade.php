@extends('layouts.admin')
@section('title',__('menu.periodique'))

@section('actions')

@endsection

@section('content')
<div class="col-12">
    <div class="row d-none">
        @include('admin.royalties.partials.filtre',['route'=>'royalties.station'])

        <div class="col-12 col-lg-3">
            <div class="row justify-content-end">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="col-12 d-flex justify-content-between">
                                <span class="text-muted">TOTAL RAYALTIES</span>
                                <span class="font-weight-bold">{{ number_format($ca_royalties??0,2,',',' ') }} {{ $_devise??'' }}</span>
                            </div>
                            <div class="col-12  d-flex justify-content-between">
                                <span class="text-muted">TOTAL CA HT</span>
                                <span class="font-weight-bold">{{ number_format($ca??0,2,',',' ') }} {{ $_devise??'' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {{-- <h4>Liste des annees</h4> --}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            @include('admin.royalties.partials.chart-year',[
                                'chiffre_affaires'=>$groupsByYears,
                                'j'=>'00',
                                'col'=>'col-lg-6'
                            ])
                        </div>
                        <div class="col-12 col-lg-6">
                            <table class="table table-sm table-striped">
                                <tr class="bg-dark">
                                    <td>{{ __('general.annee') }}</td>
                                    <td class="text-right">{{ __('boutique.ca') }}</td>
                                    <td class="text-right">{{ __('boutique.commandes') }}</td>
                                    <td class="text-right">{{ __('general.taux_royalties') }}</td>
                                </tr>
                                @foreach ($groupsByYears as $key=> $group)
                                    <tr class="{{ $param==$key?'bg-success':'' }}" data-href="{{ route('royalties.periodique',$key) }}" style="cursor: pointer" title="{{ __('general.afficher') }}">
                                        {{-- <a href="{{ route('royalties.periodique',$key) }}" class="text-dark"> --}}
                                            <td>{{ $key }}</td>
                                            <td class="text-right">{{ number_format($group->sum('montant_ht'),0,'',' ') }}</td>
                                            <td class="text-right">{{ number_format(count($group),0,'',' ') }}</td>
                                            <td class="text-right">
                                                {{
                                                    number_format($group->sum(function($q){
                                                        return ($q->montant_ht*($q->taux_royalties??1)/100);
                                                    }) ,0,'',' ')
                                                }}
                                            </td>
                                        {{-- </a> --}}
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="accordion" id="accordionExample">
                @php $i = 0;@endphp
                @foreach ($groupsByYear as $key => $year)

                    @include('admin.royalties.partials.collapse',[
                        'id'=>$key,
                        'name'=>$key,
                        'data'=>$year
                    ])
                    @php $i++;@endphp
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable','paging'=>false])
    <script>
        $('.delete-station').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm(<?php echo json_encode(__('station.alert')); ?>)) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
