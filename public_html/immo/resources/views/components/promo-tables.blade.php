{{-- @extends('layouts.admin')
@section('title', $titre) --}}
<?php use Carbon\Carbon; ?>
@section('content')
@section('tableHeader')

    <tr>
       <td>Nom</td>
       <td>Debut</td>
       <td>Fin</td>
       <td>Description</td>
       <td></td>
    </tr>

@endsection
@section('tableBody')
    @php $i = 1 @endphp
    @foreach ($promotions as $promotion)
        <tr>
            <td style="width: 300px">{{ $promotion->nom }}</td>
            <td> {{ Carbon::create($promotion->debut)->locale('fr')->isoFormat('D MMMM Y') }}</td>
            <td> {{ Carbon::create($promotion->fin)->locale('fr')->isoFormat('D MMMM Y') }}</td>
            <td>{{ $promotion->description }}</td>
            <td class="text-center"><a href="{{ route('admin.promotions.show', $promotion->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a></td>
        </tr>
        @php $i++ @endphp
    @endforeach
@endsection
@include('layouts.sub_layouts.datatable')
@endsection

@section('scriptBottom')
@include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
