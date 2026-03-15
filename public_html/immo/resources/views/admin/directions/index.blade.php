@extends('layouts.admin')
@section('title','Directions')

@section('actions')
    <div class="actions dropdown-menu-right action-btn">
        @include('partials.components.modalElement',['title'=>'Ajouter une direction','route'=>'admin.directions.store','key'=>'direction','params1'=>$postes])
        @include('partials.components.headTitlePageElement',['isModal' => true])
    </div>

@endsection

@section('content')
    {{-- table header --}}
    @section('tableHeader')
        <tr>
            <td>N°</td>
            {{-- <td>Image</td> --}}
            <td>Nom</td>
            <td> Directeur</td>
            <td>Etat</td>
            <td class="text-center">Action(s)</td>
        </tr>
    @endsection

    {{-- Table Body --}}
    @section('tableBody')
    @php $i = 1 @endphp
        @foreach ($directions as $direction)
            <tr>
                <td>{{ $i }}</td>
                {{-- <td>
                    @if ($direction->image)
                        <img class="img-thumbnail bg-primary logo" src="{{ $direction->image }}" style="height: 30px" alt="Logo">
                    @endif
                </td> --}}
                <td>{{ $direction->name }}</td>
                <td> {{ $direction->directeur() ? $direction->directeur()->nom_complet : '---' }} </td>
                <td>
                    {!! $direction->etatBadge !!}
                </td>
                <td class="text-center">
                    <button type="button" data-url="{{ url('/admin/directions', $direction->id) }}" value="{{ $direction->id.'+'.$direction->name.'+'.$direction->etat.'+'.$direction->image.'+'.$direction->poste_id  }}" class="btn btn-warning btn-sm edit_btn_modal" data-toggle="modal" data-target="#editModal">
                        <i class="fa fa-edit"></i>
                    </button>
                    <!--
                    @include('partials.components.deleteBtnElement',[
                        'url'=>route('admin.directions.destroy',$direction->id),
                        'message_confirmation'=>'Voulez-vous vraiment supprimer la direction:' .$direction->name.'?',
                        'btnInnerHTML'=>'<i class="fa fa-trash"></i>',
                        'class'=>'btn btn-danger btn-xs',
                        'entity'=>$direction
                    ])
                    -->
                </td>
            </tr>
            @php $i++ @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable')

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
