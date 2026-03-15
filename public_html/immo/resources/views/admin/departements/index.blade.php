@php
    $title = __('Régions');
@endphp
@extends('layouts.admin')
@section('title',$title)
@section('subtitle','Regions')


@section('content')
    @include('admin.departements.create')
    @section('tableHeader')
        <tr>
            <td>{{ __('general.libelle') }}</td>
            <td>{{ __('general.commune') }}</td>
            <td>{{ __('menu.biens') }}</td>
            <td class="action text-center">Action(s)</td>
        </tr>
    @endsection
    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1; @endphp
        @foreach ($departements as $departement)
        <tr>
            <td>{{ $departement->name }}</td>
            <td>{{ $departement->communes->count() }}</td>
            <td>{{ $departement->biens->count() }}</td>
            <td class="text-center">
                <a href="{{ route('admin.departements.update', $departement->id)  }}"
                    departement="button"
                    data-toggle="modal"
                    data-name='{{ $departement->name }}'
                    class="btn btn-warning btn-xs editModal">
                    <i class="fa fa-edit"></i>
                </a>
                <form method="POST" action="/admin/departements/{{$departement->id}}" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button departement="submit" class="btn btn-xs btn-danger  delete-departement"> <i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @php $i++; @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable',['atr'=>'departements'])

@endsection

@section('scriptBottom')
    <script src="{{ asset('js/scriptType.js') }}"></script>

    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>
        $('.delete-departement').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm(<?php echo json_encode(__('departement.alert')); ?>)) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
