@php
    $nbre_postes = 'Liste des postes';
@endphp
@extends('layouts.admin')
@section('title',$nbre_postes)
@section('subtitle','Postes')

@section('actions')
    @include('partials.components.headTitlePageElement',['url' => 'admin/postes/create'])
@endsection

@section('content')
    @section('tableHeader')
        <tr>
            <td>Intitulé poste</td>
            <td class="action text-center">Action(s)</td>
        </tr>
    @endsection
    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1; @endphp
        @foreach ($postes as $poste)
        <tr>
            <td>{{ $poste->name }}</td>
            <td class="text-center">
                <a href="{{ route('admin.postes.edit', $poste->id)  }}" class="btn btn-warning btn-xs">
                    <i class="fa fa-edit"></i>
                </a>
                <form method="POST" action="/admin/postes/{{$poste->id}}" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-xs btn-danger  delete-poste"> <i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @php $i++; @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable',['atr'=>'postes'])

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>
        $('.delete-poste').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm('Voulez vous vraiment supprimer cet poste ?')) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
