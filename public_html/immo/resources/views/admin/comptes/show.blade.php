
@extends('layouts.admin')
@section('title',"Visualisation d'une filiale")

@section('actions')

    @include('partials.components.headTitlePageElement',['urlback'=>'','title'=>__('Retour')])

@endsection

@section('content')
    <div class="col-12 col-md-6">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="row">
                    <div class="tab-content profil_infos px-2" id="myTabContent">
                        <div class="tab-pane fade show active" id="compte" role="tabpanel"
                            aria-labelledby="compte-tab">
                            <div class="profile-work">

                                @include('components.tab_title',[
                                    'title'=>"Information de la filiale",
                                    'class'=>'bg-primary'
                                ])
                                <div class="tab-content profil_infos" id="myTabContent">
                                    <div class="tab-pane fade show active" id="compte" role="tabpanel"
                                        aria-labelledby="compte-tab">

                                        @if (isset($compte))
                                            <div class="row">
                                                @include('admin.comptes.fiche')
                                            </div>
                                        @else
                                            Aucune Information de la filiale
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($compte))
            @include('admin.comptes.fiche-admin')
        @endif
    </div>
    <div class="col-12 col-md-6">
        <div class="row">
            @php
                $datas = [
                    [
                        'title'=>'Produits',
                        'nbre'=>$compte->produits->count(),
                        'icon'=>'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                        'route'=>''
                    ],
                    [
                        'title'=>'Fournisseurs',
                        'nbre'=>$compte->fournisseurs->count(),
                        'icon'=>'<iconify-icon icon="dashicons:admin-users" width="24" height="24"></iconify-icon>',
                        'route'=>''

                    ],
                    [
                        'title'=>'Boutiques',
                        'nbre'=>$compte->stations->count(),
                        'icon'=>'<iconify-icon icon="grommet-icons:shop" width="24" height="24"></iconify-icon>',

                    ],
                    [
                        'title'=>'Utilisateurs',
                        'nbre'=>$compte->users->count(),
                        'icon'=>'<iconify-icon icon="clarity:users-line" width="24" height="24"></iconify-icon>',
                        'route'=>''
                    ],
                ];
            @endphp
            @include('admin.comptes.card',[
                'datas'=>$datas
            ])
        </div>
    </div>
    @include('admin.comptes.btnSection')
    @include('admin.comptes.modalEdit',['compte'=>$compte])
    {{-- @include('admin.users.liste',['users'=>$compte->users])
    @include('layouts.sub_layouts.datatable') --}}

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
