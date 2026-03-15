@php
    $nbre_zones = __('zone.title_list');
@endphp
@extends('layouts.admin')
@section('title',$nbre_zones)
@section('subtitle','zones')



@section('content')
    @include('admin.zones.create')

    @section('tableHeader')
        <tr>
            <td>{{ __('zone.name') }}</td>
            @if ($_user->is_admin)
                <td>{{ __('general.compte') }}</td>
            @endif
            <td class="action text-center">Action(s)</td>
        </tr>
    @endsection
    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1; @endphp
        @foreach ($zones as $zone)
        <tr>
            <td>{{ $zone->nom }}</td>
            @if ($_user->is_admin)
                <td>{{ isset($zone->compte) ? $zone->compte->libelle:'---' }}</td>
            @endif
            <td class="text-center">
                <a href="{{ route('admin.zones.edit', $zone->id)  }}" class="btn btn-warning btn-xs">
                    <i class="fa fa-edit"></i>
                </a>
                <form method="POST" action="/admin/zones/{{$zone->id}}" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-xs btn-danger  delete-zone"> <i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @php $i++; @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable',['atr'=>'zones'])

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
    <script>
        $('.delete-zone').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm( <?php echo json_encode(__('zone.alert')); ?> )) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
