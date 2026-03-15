@extends( ($_user->profil == 'superviseur') ? 'layouts.superviseur' : 'layouts.admin')
@section('title','Filiales')
@php
    $espace = $_user->is_admin ? 'admin':'superviseurs';
@endphp
@section('actions')
    @if($_user->is_admin)
        @include('partials.components.headTitlePageElement',['url'=>'admin/comptes/create','title'=>__('Nouveau')])
    @endif
@endsection

@section('content')
    {{-- table header --}}
    @section('tableHeader')
    <tr>
        <td>N°</td>
        <td>{{ __('tableau.libelle') }} </td>
        <td>{{ __('tableau.pays') }}</td>
        <td>{{ __('tableau.utilisateurs') }}</td>
        <td>Devise</td>
        <td>Conversion(Euro)</td>
        <td>Coordonnées(Lon/Lat)</td>
        <td class="text-center">Action(s)</td>
    </tr>
    @endsection

    {{-- Table Body --}}
    @section('tableBody')
    @php $i = 1 @endphp
        @foreach ($comptes as $compte)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $compte->libelle }}</td>
            <td>{{ $compte->pays }}</td>
            <td>{{ $compte->users->count() }}</td>
            <td>{{ $compte->devise? $compte->devise->libelle :'' }}</td>
            <td>{{ $compte->devise? $compte->devise->conversion :'' }}</td>
            <td>{{ $compte->lon??'---'}} / {{ $compte->lat??'---'}}</td>
            <td class="text-center">
                <a href="{{ route($espace.'.comptes.show',$compte->id) }}" class="btn btn-danger btn-xs">
                    <i class="fa fa-eye"></i>
                </a>
            </td>
        </tr>
        @php $i++ @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable')

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
