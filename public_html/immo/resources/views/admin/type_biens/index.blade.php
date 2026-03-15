@php
    $title = __('type_biens');
@endphp
@extends('layouts.admin')
@section('title',$title)
@section('subtitle','type_biens')


@section('content')
    @include('admin.type_biens.create')
    @section('tableHeader')
        <tr>
            <td>{{ __('general.libelle') }}</td>
            <td class="action text-center">Action(s)</td>
        </tr>
    @endsection
    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1; @endphp
        @foreach ($type_biens as $type)
        <tr>
            <td>{{ $type->name }}</td>
            <td class="text-center">
                <a href="{{ route('admin.type_biens.update', $type->id)  }}"                     
                    type="button"
                    data-toggle="modal"
                    data-name='{{ $type->name }}'
                    class="btn btn-warning btn-xs editModal">
                    <i class="fa fa-edit"></i>
                </a>
                <form method="POST" action="/admin/type_biens/{{$type->id}}" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-xs btn-danger  delete-type"> <i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @php $i++; @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable',['atr'=>'type_biens'])

@endsection

@section('scriptBottom')
<script src="{{ asset('js/scriptType.js') }}"></script>
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>
        $('.delete-type').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm(<?php echo json_encode(__('type.alert')); ?>)) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
