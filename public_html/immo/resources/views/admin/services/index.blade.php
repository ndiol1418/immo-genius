@extends('layouts.admin')
@section('title','Services')

@section('actions')
    <div class="actions dropdown-menu-right action-btn">
        @include('partials.components.modalElement',['title'=>'Ajouter un Service','route'=>'admin.services.store','key'=>'service','params'=>[
            [
                'name'=>'departement_id',
                'values'=>$_departements,
                'title'=>'Département'
            ],
            [
                'name'=>'direction_id',
                'values'=>$_directions,
                'title'=>'Direction'
            ]
        ],'params1'=>$postes])
        @include('partials.components.headTitlePageElement',['isModal' => true])
    </div>
@endsection

@section('content')
    {{-- table header --}}
    @section('tableHeader')
        <tr>
            <td>N°</td>
            <td>Nom </td>
            <td>Chef de service</td>
            <td>Département</td>
            <td>Direction</td>
            <td>Etat</td>
            <td>Action(s)</td>
        </tr>
    @endsection

    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1 @endphp
        @foreach ($services as $service)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $service->name }}</td>
            <td>{{ $service->chefDeService() ? $service->chefDeService()->nom_complet : '---' }}</td>
            <td>{{ $service->departement->name ?? '---'}}</td>
            <td>{{ $service->direction->name ?? "---"  }}</td>
            <td>{!! $service->etatBadge !!}</td>
            <td>
                <a href="/admin/services/{{  $service->id  }}/edit" class="btn btn-warning btn-xs">
                    <i class="fa fa-edit"></i>
                </a>
                <!-- form method="POST" action="/admin/services/{{$service->id}}" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-xs btn-danger  delete-service"> <i class="fa fa-trash"></i></button>
                </form -->

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
    <script src="{{ asset('js/partials/modalSelect.js') }}"></script>
    <script>
        $('.delete-service').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm('Voulez vous vraiment supprimer cet service ?')) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>

@endsection
