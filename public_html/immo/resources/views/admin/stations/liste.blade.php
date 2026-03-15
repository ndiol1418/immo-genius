<style>
    .dropdown-toggle::after {
        display: none;
    }
</style>
   {{-- table header --}}
        @section('tableHeader')
        <tr>
            <td>{{ __('N°') }}</td>
            <td>{{ __('boutique.libelle') }} </td>
            {{-- <td>{{ __('boutique.coordonnees') }} </td> --}}
            {{-- <td>{{ __('boutique.adresse') }}</td>
            <td>{{ __('boutique.code') }}</td>
            <td>{{ __('boutique.alcool') }}</td>
            <td>{{ __('boutique.gamme') }}</td>
            <td>{{ __('boutique.zone') }}</td> --}}
            {{-- @if($_user->is_admin) --}}
            <td>{{ __('boutique.plateforme') }}</td>
            <td class="text-center">{{ __('boutique.actions') }}</td>
            {{-- @endif --}}
        </tr>
        @endsection

        {{-- Table Body --}}
        @section('tableBody')
        @php $i = 1 @endphp
        @foreach ($stations as $i => $station)
        <tr>
            <td>{{ $i + 1}}</td>
            <td><a href="{{ route('admin.stations.show',$station->id) }}" class="text-dark">{{ isset($station) ? $station->nom : "---" }}</a></td>
            {{-- <td>{{ $station->lon.' '.$station->lat }}</td> --}}
            {{-- <td>{{ $station->adresse }}</td>
            <td>{{ $station->code_station }}</td>
            <td>{!!  $station->is_alcool !!}</td>
            <td>{{ $station->gamme?$station->gamme->nom:'' }}</td>
            <td>{{ $station->zone?$station->zone->nom:'' }}</td> --}}
            <td>{!! $station->deploiement !!}</td>
            {{-- @if($_user->is_admin) --}}
                <td class="text-center">
                    <button class="btn btn-xs btn-light checkShop"
                        data-lat ="{{ $station->lat }}"
                        data-nom ="{{ $station->nom }}"
                        data-adresse ="{{ $station->adresse }}"
                        data-email ="{{ $station->user->email }}"
                        data-telephone ="{{ $station->user->telephone }}"
                        data-lon ="{{ $station->lon  }}">
                        <i class="fa fa-map-pin"></i>
                    </button>
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('admin.stations.show',$station->id) }}" class="btn btn-success btn-sm dropdown-item">
                            <i class="fa fa-eye"></i> {{ __('boutique.visualiser') }}
                        </a>
                        <a href="{{ route('admin.stations.edit',$station->id) }}" class="btn btn-success btn-sm dropdown-item">
                            <i class="fa fa-edit"></i> {{ __('boutique.editer') }}
                        </a>

                        @include('partials.components.deleteBtnElement',[
                            'url'=>route('admin.stations.destroy',$station->id),
                            'message_confirmation'=>'Voulez-vous vraiment supprimer le département:' .$station->name.'?',
                            'btnInnerHTML'=>'<i class="fa fa-trash"></i>  '.__('boutique.supprimer'),
                            'class'=>'btn btn-success btn-sm dropdown-item',
                            'entity'=>$station
                        ])
                        {{-- <a href="{{ route('admin.stations.update', $station->id)  }}" class="btn btn-white btn-sm editModal dropdown-item"
                            data-toggle="modal"
                            data-id="{{ $station->id }}"
                            data-nom="{{ $station->nom }}"
                            data-adresse="{{ $station->adresse }}"
                            data-is_alcool="{{ $station->is_alcool }}"
                            data-lat="{{ $station->lat }}"
                            data-lon="{{ $station->lon }}"
                            data-gamme="{{ $station->gammes() }}"
                            data-zone="{{ $station->zone_id }}"
                            data-target="#editModal">
                                <i class="fa fa-edit"></i> Modifier
                        </a> --}}
                    </div>

                    {{-- <a href="{{ route('admin.stations.show',$station->id) }}" class="btn btn-success btn-xs">
                        <i class="fa fa-eye"></i>
                    </a> --}}
                    {{-- <a href="{{ route('admin.stations.update', $station->id)  }}" class="btn btn-warning btn-sm editModal"
                        data-toggle="modal"
                        data-id="{{ $station->id }}"
                        data-nom="{{ $station->nom }}"
                        data-adresse="{{ $station->adresse }}"
                        data-is_alcool="{{ $station->is_alcool }}"
                        data-lat="{{ $station->lat }}"
                        data-lon="{{ $station->lon }}"
                        data-gamme="{{ $station->gammes() }}"
                        data-zone="{{ $station->zone_id }}"
                        data-target="#editModal">
                            <i class="fa fa-edit"></i>
                        </a>
                    @include('partials.components.deleteBtnElement',[
                        'url'=>route('admin.stations.destroy',$station->id),
                        'message_confirmation'=>'Voulez-vous vraiment supprimer le département:' .$station->name.'?',
                        'btnInnerHTML'=>'<i class="fa fa-trash"></i>',
                        'class'=>'btn btn-danger btn-xs',
                        'entity'=>$station
                    ]) --}}
                </td>
            {{-- @endif --}}
        </tr>
        @endforeach
        @endsection
