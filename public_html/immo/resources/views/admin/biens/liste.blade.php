<style>
    .dropdown-toggle::after {
        display: none;
    }
</style>
{{-- table header --}}
@section('tableHeader')
    <tr>
        {{-- <td>{{ __('N°') }}</td> --}}
        <td>{{ __('bien.libelle') }} </td>
        <td>{{ __('bien.montant') }} </td>
        <td>{{ __('bien.commune') }}</td>
        @if(isset($_user->role) && in_array($_user->role->profil_id,[1]))
            <td>Agent</td>
        @endif
        <td class="text-center">{{ __('bien.actions') }}</td>
        {{-- @endif --}}
    </tr>
@endsection

{{-- Table Body --}}
@section('tableBody')
@php $i = 1 @endphp
@foreach ($biens as $bien)
    <tr>
        <td>
            <a href="{{ route($_espace.'.biens.show',$bien->id) }}" class="text-dark">{{ isset($bien) ? $bien->name : "---" }}</a>
        </td>
        <td>{{ number_format($bien->montant,0,'',' ') }}</td>
        <td>{{ $bien->commune?$bien->commune->name:'' }}</td>
        @if(isset($_user->role) && in_array($_user->role->profil_id,[1]))
            <td>{!!  $bien->fournisseur?$bien->fournisseur->nom_complet:'<span class="badge badge-danger">Admin</span>' !!}</td>
        @endif
        <td class="text-center">
            <button class="btn btn-xs btn-light checkShop"
                data-lat ="{{ $bien->lat }}"
                data-nom ="{{ $bien->name }}"
                data-commune ="{{ $bien->commune->name }}"
                data-montant ="{{ number_format($bien->montant,0,'',' ').' CFA' }}"
                data-adresse ="{{ $bien->adresse }}"
                data-lon ="{{ $bien->lon  }}">
                <i class="fa fa-map-pin"></i>
            </button>
            @if($_user->role->profil_id == 1)
                <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu">
                    <a href="{{ route($_espace.'.biens.show',$bien->id) }}" class="btn btn-success btn-sm dropdown-item">
                        <i class="fa fa-eye"></i> {{ __('bien.visualiser') }}
                    </a>
                    <a href="{{ route($_espace.'.biens.edit',$bien->id) }}" class="btn btn-success btn-sm dropdown-item">
                        <i class="fa fa-edit"></i> {{ __('bien.editer') }}
                    </a>

                    @include('partials.components.deleteBtnElement',[
                        'url'=>route($_espace.'.biens.destroy',$bien->id),
                        'message_confirmation'=>'Voulez-vous vraiment supprimer le département:' .$bien->name.'?',
                        'btnInnerHTML'=>'<i class="fa fa-trash"></i>  '.__('bien.supprimer'),
                        'class'=>'btn btn-success btn-sm dropdown-item',
                        'entity'=>$bien
                    ])
                    {{-- <a href="{{ route($_espace.'.biens.update', $bien->id)  }}" class="btn btn-white btn-sm editModal dropdown-item"
                        data-toggle="modal"
                        data-id="{{ $bien->id }}"
                        data-nom="{{ $bien->nom }}"
                        data-commune="{{ $bien->commune }}"
                        data-is_alcool="{{ $bien->is_alcool }}"
                        data-lat="{{ $bien->lat }}"
                        data-lon="{{ $bien->lon }}"
                        data-gamme="{{ $bien->gammes() }}"
                        data-zone="{{ $bien->zone_id }}"
                        data-target="#editModal">
                            <i class="fa fa-edit"></i> Modifier
                    </a> --}}
                </div>
            @endif

            {{-- <a href="{{ route($_espace.'.biens.show',$bien->id) }}" class="btn btn-success btn-xs">
                <i class="fa fa-eye"></i>
            </a> --}}
            {{-- <a href="{{ route($_espace.'.biens.update', $bien->id)  }}" class="btn btn-warning btn-sm editModal"
                data-toggle="modal"
                data-id="{{ $bien->id }}"
                data-nom="{{ $bien->nom }}"
                data-commune="{{ $bien->commune }}"
                data-is_alcool="{{ $bien->is_alcool }}"
                data-lat="{{ $bien->lat }}"
                data-lon="{{ $bien->lon }}"
                data-gamme="{{ $bien->gammes() }}"
                data-zone="{{ $bien->zone_id }}"
                data-target="#editModal">
                    <i class="fa fa-edit"></i>
                </a>
            @include('partials.components.deleteBtnElement',[
                'url'=>route($_espace.'.biens.destroy',$bien->id),
                'message_confirmation'=>'Voulez-vous vraiment supprimer le département:' .$bien->name.'?',
                'btnInnerHTML'=>'<i class="fa fa-trash"></i>',
                'class'=>'btn btn-danger btn-xs',
                'entity'=>$bien
            ]) --}}
        </td>
        {{-- @endif --}}
    </tr>
    @endforeach
@endsection
