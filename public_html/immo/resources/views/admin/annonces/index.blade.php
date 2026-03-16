@extends('layouts.admin')
@section('title')
Liste des annonces {{ isset($titre)?$titre:'' }}
@endsection

@section('content')
    {{-- @section('entete')
        @include('partials.components.headTitlePageElement',['url'=>'admin/users/create'])
    @endsection --}}
    <!-- Dropdown - User Information -->
    @section('tableHeader')
        <tr>
            <td>Agent</td>
            <td>Date</td>
            <td>Libelle</td>
            <td>Prix</td>
            <td>Adresse</td>
            <td>Actions</td>
        </tr>
    @endsection

    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1 @endphp
        @foreach ($annonces as $annonce)
        <tr>
            <td>{{$annonce->immo->fournisseur?$annonce->immo->fournisseur->nom_complet:'Teranga Immobilier' }} </td>
            <td>{{ $annonce->created_at->format('d-m-Y') }} <br><small class="text-danger">{{  $annonce->created_at->diffForHumans() }}</small></td>
            <td>{{ $annonce->name }} </td>
            <td>{{ number_format($annonce->prix,0,'',' ') }} </td>
            <td>{{ $annonce->adresse }} </td>
            <td>
                    <a type="button" href="{{ route('annonce',$annonce->slug) }}" target="_blank" class="btn btn-dark btn-sm edit_btn_modal">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a type="button" href="{{ route($_espace.'.annonces.edit',$annonce->id) }}" class="btn btn-warning btn-sm edit_btn_modal">
                        <i class="fa fa-edit"></i>
                    </a>
                    {{-- @include('partials.components.deleteBtnElement',[
                        'url'=>route($_espace.'.annonces.destroy',$annonce->id),
                        'message_confirmation'=>'Voulez-vous vraiment supprimer: ' .$annonce->name.'?',
                        'btnInnerHTML'=>'<i class="fa fa-trash"></i>  '.__(''),
                        'class'=>'btn btn-danger btn-xs',
                        'entity'=>$annonce
                    ]) --}}
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

