@php
    $nbre_immos = __('menu.immos');
@endphp
@extends('layouts.admin')
@section('title',$nbre_immos)
@section('subtitle','immos')
@section('actions')
<a href="{{ route($_espace.'.immos.create') }}" class="btn btn-primary btn-xs text-white px-2">Ajouter</a>
@endsection

@section('content')

    @section('tableHeader')
        <tr>
            <td>{{ __('Libelle') }}</td>
            <td>{{ __('Prix') }}</td>
            @if(isset($_user->role) && in_array($_user->role->profil_id,[1]))
                <td>Agent</td>
            @endif
            @if(in_array($_user->role->profil_id ,[1,2]))
            <td class="action text-center">Action(s)</td>
            @endif
        </tr>
    @endsection
    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1; @endphp
        @foreach ($immos as $immo)
        <tr>
            <td>{{ $immo->name }}</td>
            <td>{{ number_format($immo->montant,0,'',' ') }}</td>
            @if(isset($_user->role) && in_array($_user->role->profil_id,[1]))
                <td>{!!  $immo->fournisseur?$immo->fournisseur->nom_complet:'<span class="badge badge-danger">Admin</span>' !!}</td>
            @endif
            @if(in_array($_user->role->profil_id ,[1,2]))
                <td class="text-center">
                    @can('modif',$immo)
                        <a href="{{ route($_espace.'.immos.create',['immo'=>$immo->id]) }}" class="btn btn-xs btn-danger">
                            <i class="fa fa-share"></i>
                        </a>
                        <a href="{{ route($_espace.'.immos.show',$immo->id) }}" class="btn btn-xs btn-success">
                            <i class="fa fa-eye"></i>
                        </a>
                       
                    @endcan
                </td>
            @endif
        </tr>
        @php $i++; @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable',['atr'=>'immos'])

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>
        $('.delete-immo').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm( <?php echo json_encode(__('immo.alert')); ?> )) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
