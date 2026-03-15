@php
    $title = __("Types d'annonces");
@endphp
@extends('layouts.admin')
@section('title',$title)
@section('subtitle','type_locations')


@section('content')
    @include('admin.type_locations.create')
    @section('tableHeader')
        <tr>
            <td>{{ __('general.libelle') }}</td>
            <td class="action text-center">Action(s)</td>
        </tr>
    @endsection
    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1; @endphp
        @foreach ($type_locations as $type_location)
        <tr>
            <td>{{ $type_location->name }}</td>
            <td class="text-center">
                <a href="{{ route('admin.type_locations.update', $type_location->id)  }}"
                    type_location="button"
                    data-toggle="modal"
                    data-name='{{ $type_location->name }}'
                    class="btn btn-warning btn-xs editModal">
                    <i class="fa fa-edit"></i>
                </a>
                <form method="POST" action="/admin/type_locations/{{$type_location->id}}" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type_location="submit" class="btn btn-xs btn-danger  delete-type_location"> <i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @php $i++; @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable',['atr'=>'type_locations'])

@endsection

@section('scriptBottom')
    <script src="{{ asset('js/scripttype_location.js') }}"></script>

    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>
        $('.delete-type_location').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm(<?php echo json_encode(__('type_location.alert')); ?>)) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
