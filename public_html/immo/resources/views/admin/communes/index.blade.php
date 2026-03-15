@php
    $title = __('Communes');
@endphp
@extends('layouts.admin')
@section('title')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('admin.departements.index') }}">Régions</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Communes
        </li>
    </ol>
</nav>
@endsection

@section('content')
    @include('admin.communes.create')
    @section('tableHeader')
        <tr>
            <td>{{ __('general.libelle') }}</td>
            <td>{{ __('menu.department') }}</td>
            <td>{{ __('menu.biens') }}</td>
            <td class="action text-center">Action(s)</td>
        </tr>
    @endsection
    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1; @endphp
        @foreach ($communes as $commune)
        <tr>
            <td>{{ $commune->name }}</td>
            <td>{{ $commune->departement->name }}</td>
            <td>{{ $commune->biens->count() }}</td>
            <td class="text-center">
                <a href="{{ route('admin.communes.update', $commune->id)  }}"
                    commune="button"
                    data-toggle="modal"
                    data-name='{{ $commune->name }}'
                    class="btn btn-warning btn-xs editModal">
                    <i class="fa fa-edit"></i>
                </a>
                <form method="POST" action="/admin/communes/{{$commune->id}}" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button commune="submit" class="btn btn-xs btn-danger  delete-commune"> <i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @php $i++; @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable',['atr'=>'communes'])

@endsection

@section('scriptBottom')
    <script src="{{ asset('js/scriptType.js') }}"></script>

    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>
        @if (count($errors) > 0)
            $('#form');
        @endif
        $('.delete-commune').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm(<?php echo json_encode(__('commune.alert')); ?>)) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
