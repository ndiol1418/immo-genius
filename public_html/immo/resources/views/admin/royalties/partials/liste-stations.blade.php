@section('tableHeader')
    <tr>
        <td>{{ __('general.station') }}</td>
        <td>{{ __('general.nbre_commande') }}</td>
        {{-- <td>{{ __('general.taux_royalties') }}</td> --}}
        <td class="text-right">{{ __('boutique.ca') }}</td>
        <td class="text-right">{{ __('general.ca_taux_royalties') }}</td>
    </tr>
@endsection
{{-- Table Body --}}
@section('tableBody')
@php $i = 1; @endphp
    @foreach ($stations as $key=>$station)
    <tr>
        <td><a href="{{ route('admin.stations.show',$station->id) }}" class="text-dark">{{ isset($station) ? $station->nom : "---" }}</a></td>
        <td>{{ $station->royalties()['commandes'] ?? "---" }}</td>
        {{-- <td>{{ $station->taux_royalties ?? "---" }}</td> --}}
        <td class="text-right">{{ $station->getCaCurrentMonth() ?? "---" }}</td>
        <td class="text-right">{{ $station->ca_royalties() ?? "---" }}</td>
    </tr>
    @endforeach
@endsection
@include('layouts.sub_layouts.datatable',['atr'=>'commandes','infos_supplementaires'=>[]])
{{-- @push('subScript') --}}
    @include('partials.utilities.datatableElement', ['id' => 'datatable','paging'=>false])
{{-- @endpush --}}
