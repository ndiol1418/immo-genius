@extends('layouts.admin')
@section('title','Logs du système')

@section('content')
    {{-- @section('entete')
        @include('partials.components.headTitlePageElement',['url'=>'admin/users/create'])
    @endsection --}}
    <!-- Dropdown - User Information -->
    @section('tableHeader')
        <tr>
            <td>N°</td>
            <td>Objet</td>
            <td>Commentaire</td>
            <td>Collaborateur</td>
            <td>Date</td>
        </tr>
    @endsection

    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1 @endphp
        @foreach ($actions as $action)

        <tr>
            <td>{{ $i }} </td>
            <td>{{ $action->type }} </td>
            <td>{{ $action->commentaire }} </td>
            <td>{{  isset($action->user->collaborateur) ? $action->user->collaborateur->prenom.' '. $action->user->collaborateur->nom  : '' }}</td>
            <td><small>{{  $action->created_at->diffForHumans() }}</small></td>
        </tr>
        @php $i++ @endphp
        @endforeach
    @endsection

    @section('cardFooter')
        <div class="d-flex justify-content-center">
            {{ $actions->links() }}
        </div>
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable')



@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection

