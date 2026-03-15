@section('tableHeader')
    <tr>
        <td>{{ __('Prenom') }}</td>
        <td>{{ __('Nom') }}</td>
        <td>{{ __('Adresse') }}</td>
        <td>{{ __('fournisseur.telephone') }}</td>
        <td>{{ __('Experience') }}</td>

        <td class="action text-center">Action(s)</td>
    </tr>
@endsection
{{-- Table Body --}}
@section('tableBody')
@php $i = 1; @endphp
@foreach ($fournisseurs as $fournisseur)
    <tr data-href="{{ route($_espace.'.agents.show',$fournisseur->id) }}" title="visualiser">
        <td>{{ $fournisseur->nom }}</td>
        <td>{{ $fournisseur->prenom }}</td>
        <td>{{ $fournisseur->adresse }}</td>
        <td>{{ $fournisseur->telephone }}</td>
        <td>{{ $fournisseur->experience }}</td>
        <td>
            <a class="btn btn-xs btn-primary" href="{{ route('admin.fournisseurs.edit',$fournisseur->id) }}"><i class="fa fa-edit"></i></a>
        </td>
    </tr>
@php $i++; @endphp
@endforeach
@endsection

{{-- Datatable extension --}}
@include('layouts.sub_layouts.datatable',['atr'=>'fournisseurs'])
