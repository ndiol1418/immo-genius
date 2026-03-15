
@extends('layouts.admin')
@section('title','Listes')
@section('subtitle','listes')

@section('actions')
    @include('partials.components.headTitlePageElement',['url' => 'admin/listes/create'])
@endsection

@section('content')
    @section('tableHeader')
        <tr>
            <td>Libellé</td>
            <td>Attributs</td>
            <td>Identifiant</td>
            <td class="action text-center">Action(s)</td>
        </tr>
    @endsection
    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1; @endphp
        @foreach ($listes as $liste)
        <tr>
            <td>{{ $liste->libelle }}</td>
            <td>
                @foreach ($liste->attributs as $attribut)
                    <span class="badge badge-light">{{$attribut}}</span>
                @endforeach
            </td>
            <td>{{ $liste->identifiant }}</td>
            <td class="text-center">
                <a href="{{ route('admin.listes.edit', $liste->id)  }}" class="btn btn-warning btn-xs">
                    <i class="fa fa-edit"></i>
                </a>
                <form method="POST" action="/admin/listes/{{$liste->id}}" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-xs btn-danger  delete-liste"> <i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @php $i++; @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable',['atr'=>'listes'])

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>
        $('.delete-liste').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm('Voulez vous vraiment supprimer cette liste ?')) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
