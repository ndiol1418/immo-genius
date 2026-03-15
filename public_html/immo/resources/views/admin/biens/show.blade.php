@extends('layouts.admin')
@section('title',__('bien.title_visualisation'))
<style>
    #map { height: 221px}
    h4 {
      width: 70%;
      margin: .7em auto;
      overflow: hidden;
      text-align: center;
      font-weight:300;
      color: #adb4bc !important;
      font-size: 18px;
    }
    h4:before, h4:after {
      content: "";
      display: inline-block;
      width: 50%;
      margin: 2px .5em 0 -55%;
      vertical-align: middle;
      border-bottom: 1px solid;
      color: #ddd
    }
    h4:after {
      margin: 2px -55% 0 .5em;
    }
    /* span {
      display: inline-block;
      vertical-align: middle;
    } */
</style>
@section('actions')
@if (count($bien->immos))
<a href="{{ route($_espace.'.immos.create') }}" class="btn btn-primary btn-xs text-white px-2">Ajouter</a>
@endif
@endsection
@section('content')

    <div class="col-12">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="card shadow-none mb-4">
                    <div class="content-form">
                        <div class="card-body">
                            <div class="tab-content profil_infos px-2" id="myTabContent">
                                <div class="tab-pane fade show active" id="compte" role="tabpanel"
                                    aria-labelledby="compte-tab">
                                    <div class="profile-work">

                                        @include('components.title-separe',[
                                            'title'=>__('bien.infos'),
                                            'class'=>'text-muted mb-2'
                                        ])
                                        <div class="tab-content profil_infos" id="myTabContent">
                                            <div class="tab-pane fade show active" id="compte" role="tabpanel"
                                                aria-labelledby="compte-tab">
                                                <div class="row">
                                                    @include('components.affichage',[
                                                        'title'=>__('bien.libelle'),
                                                        'value'=>$bien->name,
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])
                                                    @include('components.affichage',[
                                                        'title'=>__('bien.adresse'),
                                                        'value'=>$bien->adresse,
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])
                                                    @include('components.affichage',[
                                                        'title'=>__('bien.commune'),
                                                        'value'=>$bien->commune?$bien->commune->name:'',
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])
                                                    @include('components.affichage',[
                                                        'title'=>__('bien.departement'),
                                                        'value'=>$bien->commune?$bien->commune->departement->name:'',
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])
                                                    @include('components.affichage',[
                                                        'title'=>__('bien.type'),
                                                        'value'=>$bien->type?$bien->type->name:'',
                                                        'style'=>1,
                                                        'col'=>'col-lg-6 col-12'
                                                    ])

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-12 col-lg-6 d-none">
                <div id="map"></div>
            </div>
            <div class="col-12 col-lg-12 d-none">
                <div class="row p-2">
                    @include('components.title-separe',[
                        'title'=>__('bien.statistique'),
                        'class'=>'text-muted mb-2'
                    ])
                    @include('components.dashboard.card-info',[
                        'title'=>__('bien.ca'),
                        'subtitle'=>__('bien.annee_encours'),
                        'class'=>'col-lg-3 col-sm-6 col-6',
                        'nbre'=>$ca,
                        'icon'=>$data['icon']??'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                        'route'=>$data['route']??false,
                        'param'=>$bien->compte->devise->libelle,
                        'key'=>$data['key']??'',
                    ])
                    @include('components.dashboard.card-info',[
                        'title'=>__("bien.ca"),
                        'subtitle'=>__('bien.ca_mois_en_cours'),
                        'class'=>'col-lg-3 col-sm-6 col-6',
                        'nbre'=>$ca_mois_en_cours,
                        'icon'=>$data['icon']??'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                        'route'=>$data['route']??false,
                        'param'=>$bien->compte->devise->libelle,
                        'key'=>$data['key']??'',
                    ])
                    @include('components.dashboard.card-info',[
                        'title'=>__("bien.ca"),
                        'subtitle'=>__('bien.mois_precedent'),
                        'class'=>'col-lg-3 col-sm-6 col-6',
                        'nbre'=>$ca_mois_precedent,
                        'icon'=>$data['icon']??'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                        'route'=>$data['route']??false,
                        'param'=>$bien->compte->devise->libelle,
                        'key'=>$data['key']??'',
                    ])
                    @include('components.dashboard.card-info',[
                        'title'=>__("bien.commandes"),
                        'subtitle'=>__('bien.commandes_encours'),
                        'class'=>'col-lg-3 col-sm-6 col-6',
                        'nbre'=>$commandes_en_cours->count(),
                        'icon'=>$data['icon']??'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                        'route'=>$data['route']??false,
                        'param'=>'',
                        'key'=>$data['key']??'',
                    ])
                </div>

            </div> --}}
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="row">

                    @if(count($bien->immos))
                    <div class="col-12">
                        <div class="row d-flex justify-content-center align-items-center">
                            @include('components.title-separe',[
                                'title'=>__('Mes Immobilisations'),
                                'class'=>'text-muted',
                                'col'=>'col-12'
                            ])
                            <div class="col-12 d-flex justify-content-end mb-2 text-center">
                                <input type="search" class="form-control form-control-sm mb-2 col-6 col-lg-3" id="search" placeholder="Rechercher...">
                            </div>
                        </div>
                    </div>
                    @foreach ($immos as $k => $immo)
                            <div class="col-lg-3 col-6">
                                <a href="{{ route($_espace.'.immos.show',$immo->id) }}">
                                    <div class="card bg-light">
                                        <div class="card-body immo">
                                            <label for="">{{ $immo->name }}</label>
                                            <p class="text-primary font-weight-bold">{{ number_format($immo->montant,0,'',' ') }} {{ $_devise??'CFA' }}</p>
                                            <p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="#b11010" d="M12 6.5A2.5 2.5 0 0 1 14.5 9a2.5 2.5 0 0 1-2.5 2.5A2.5 2.5 0 0 1 9.5 9A2.5 2.5 0 0 1 12 6.5M12 2a7 7 0 0 1 7 7c0 5.25-7 13-7 13S5 14.25 5 9a7 7 0 0 1 7-7m0 2a5 5 0 0 0-5 5c0 1 0 3 5 9.71C17 12 17 10 17 9a5 5 0 0 0-5-5"/></svg>
                                                {{ $immo->bien->commune?$immo->bien->commune->name.' / '.$immo->bien->commune->departement->name:($immo->annonce?$immo->annonce->adresse:'---') }}
                                            </p>
                                            @if ($immo->annonce)
                                                <div class="row bg-white rounded">
                                                    @php
                                                        $pieces = $immo->annonce->pieces;
                                                    @endphp
                                                    @if (count($pieces))
                                                        @for($i = 1; $i <= count($pieces); $i++)
                                                            @foreach ($pieces[$i] as $key => $piece)
                                                                <div class="col-6 d-flex w-100 justify-content-between align-items-center" style="font-size: 11px">
                                                                    {{ $key }} <span class="badge badge-danger">{{ $piece ??'---'}}</span>
                                                                </div>
                                                                
                                                            @endforeach
                                                        @endfor
                                                    @else
                                                        <div class="jumbotron">
                                                            Aucune information
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        <div class="text-primary mb-1 font-weight-bold col-12">{{ count($immos) }} immobilisation(s) sur la page</div>
                        <div class="col-12 paginate text-center d-flex justify-content-center align-items-center">
                            {{ $immos->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    @else
                    <div class="jumbotron text-center col-12">
                        <h5>Vous n'avez aucune immobilisation sur ce bien</h5>
                        <a href="{{ route($_espace.'.immos.create') }}" class="btn btn-danger">Ajouter</a>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
@push('subScript')
    <script>
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            // console.log('Test');
            $(".immo").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    
            });
        });
    </script>
@endpush
@endsection

@section('scriptBottom')
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <script>
            (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
            ({key: "AIzaSyCaSfdQyOwQoWtaDwtL5AMOm3eA492dg9M", v: "weekly"});
            </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
        {{-- @include('partials.utilities.datatableElement', ['id' => 'datatable']) --}}

        {{-- @include('admin.biens.marker') --}}
{{-- 
        @include('partials.chart.line',[
            'data'=>$array_data,
            'labels'=>$labels,
            // 'title'=>"CA par filiale",
            'line_title_1'=>__("fournisseur.chart_title_line"),
            // 'line_title_2'=>'Nbre Commande mois precedent',
            'bar_title'=>'Commandes',
            'line_title'=>"Chiffre d'affaires",
            'key_2'=>'nombre',
            'key_1'=>'montant',
            'bar_title_1'=> __("fournisseur.chart_title"),
            // 'bar_title_2'=>'CA mois précédent',
            'id'=>'myChart'
        ]) --}}
        {{-- <script>
            window.history.forward();
            function noBack() { window.history.forward(); }
        </script> --}}
@endsection
