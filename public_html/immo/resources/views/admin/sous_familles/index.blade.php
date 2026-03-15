@php
    $nbre_familles = __('famille.title_list');
@endphp
@extends('layouts.admin')
@section('title',$nbre_familles)
@section('subtitle','Sous-familles')

@section('content')
    @include('admin.sous_familles.create')
    @section('tableHeader')
        <tr>
            <td>{{ __('general.libelle') }}</td>
            <td>{{ __('general.famille') }}</td>
            <td class="action text-center">Action(s)</td>
        </tr>
    @endsection
    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1; @endphp
        @foreach ($sous_familles as $sous_famille)
        <tr>
            <td>{{ $sous_famille->libelle }}</td>
            <td>{{ isset($sous_famille->famille) ? $sous_famille->famille->libelle:'---' }}</td>
            <td class="text-center">
                <a href="{{ route('admin.sous-familles.edit', $sous_famille->id)  }}" class="btn btn-warning btn-xs">
                    <i class="fa fa-edit"></i>
                </a>
                <form method="POST" action="/admin/sous-familles/{{$sous_famille->id}}" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-xs btn-danger  delete-sous-famille"> <i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @php $i++; @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable',['atr'=>'sous-familles'])

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>
        $('.delete-sous-famille').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm(<?php echo json_encode(__('sous-famille.alert')); ?>)) {
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
