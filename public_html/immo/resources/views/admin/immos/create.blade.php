{{-- 
@php
    $nbre_gammes = __('Nouvelle Annonce');
@endphp
@extends('layouts.admin')
@section('title',$nbre_gammes)
@section('subtitle','gammes')


@section('content')
    <div class="col-md-12 card d-none">
        @php
            $icon = [
                '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M5 19h1.425L16.2 9.225L14.775 7.8L5 17.575zm-1 2q-.425 0-.712-.288T3 20v-2.425q0-.4.15-.763t.425-.637L16.2 3.575q.3-.275.663-.425t.762-.15t.775.15t.65.45L20.425 5q.3.275.437.65T21 6.4q0 .4-.138.763t-.437.662l-12.6 12.6q-.275.275-.638.425t-.762.15zM19 6.4L17.6 5zm-3.525 2.125l-.7-.725L16.2 9.225z"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M19.5 22a1.5 1.5 0 0 0 1.5-1.5V17a1.5 1.5 0 0 0-1.5-1.5c-1.17 0-2.32-.18-3.42-.55a1.51 1.51 0 0 0-1.52.37l-1.44 1.44a14.77 14.77 0 0 1-5.89-5.89l1.43-1.43c.41-.39.56-.97.38-1.53c-.36-1.09-.54-2.24-.54-3.41A1.5 1.5 0 0 0 7 3H3.5A1.5 1.5 0 0 0 2 4.5C2 14.15 9.85 22 19.5 22M3.5 4H7a.5.5 0 0 1 .5.5c0 1.28.2 2.53.59 3.72c.05.14.04.34-.12.5L6 10.68c1.65 3.23 4.07 5.65 7.31 7.32l1.95-1.97c.14-.14.33-.18.51-.13c1.2.4 2.45.6 3.73.6a.5.5 0 0 1 .5.5v3.5a.5.5 0 0 1-.5.5C10.4 21 3 13.6 3 4.5a.5.5 0 0 1 .5-.5"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3.275 15.296C2.425 14.192 2 13.639 2 12c0-1.64.425-2.191 1.275-3.296C4.972 6.5 7.818 4 12 4s7.028 2.5 8.725 4.704C21.575 9.81 22 10.361 22 12c0 1.64-.425 2.191-1.275 3.296C19.028 17.5 16.182 20 12 20s-7.028-2.5-8.725-4.704Z"/><path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0Z"/></g></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m4.5 12.75l6 6l9-13.5"/></svg>'
            ]
        @endphp
        <div class="content__card mb-4">
            <div class="row">
                @for ($i=0;$i<4;$i++)
                    <div class="col-lg col-sm-6 col-12 step {{ $i==0?'active':'' }}">
                        <hr class="step__hr">
                        <span class="step__number">{!! $icon[$i] !!}</span>
                        @if($i == 0)
                            <span class="step__label">Informations de base</span>
                        @endif
                        @if($i == 1)
                            <span class="step__label">Contact</span>
                        @endif
                        @if($i == 2)
                            <span class="step__label">Détails de l'annonce</span>
                        @endif
                    </div>
                @endfor
          
            </div>
        </div>
        <form method="POST" action="{{ route($_espace.'.immos.store') }}" enctype="multipart/form-data" class="">
            @csrf
            <div class="col-12">
                <div class="tab">
                    <div class="row">
                        @include('admin.immos.form')
                    </div>
                </div>
                <div class="tab">
                    <div class="row">
                        <div class="card">

                            <div class="card-body">
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="tab">
                    <div class="row">
                        <div class="card">

                            <div class="card-body">
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4">
                <div style="overflow:auto;">
                    <div style="float:right;">
                    <button type="button" id="prevBtn" class="btn btn-xs btn-outline-danger" onclick="nextPrev(-1)">Précèdente</button>
                    <button type="button" id="nextBtn" class="btn btn-xs btn-outline-primary" onclick="nextPrev(1)">Suivante</button>
                    </div>
                </div>
            </div>
        </form>

        <form method="POST" action="{{ route($_espace.'.immos.store') }}" enctype="multipart/form-data" class="d-none">
            @csrf
            <div class="form-group row">
                @include('admin.immos.form')
            </div>

            <div class="form-group row  mb-0">
                <div class="col-lg-4 col-12">
                    <button type="submit" class="btn btn-primary">
                        {{ __('general.valider') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scriptBottom')
    @include('admin.immos.stepJs')
@endsection --}}
@section('title',"Nouvelle Annonce")
<link href="{{ asset('css/step.css') }}" rel="stylesheet">
<link href="{{ asset('css/inputFlotant.css') }}" rel="stylesheet">
<link href="{{ asset("assets/css/style.css") }}" rel="stylesheet">

@include('template.pages.publication',['admin'=>true])
@section('scriptBottom')
    <script>
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
        
                console.log("Latitude:", latitude);
                console.log("Longitude:", longitude);
        
                // Tu peux ici ajouter un marqueur Mapbox par exemple :
                const userMarker = new mapboxgl.Marker({ color: 'blue' })
                    .setLngLat([longitude, latitude])
                    .setPopup(new mapboxgl.Popup().setText("Vous êtes ici"))
                    .addTo(map);
        
                map.setCenter([longitude, latitude]); // centrer la carte
            },
            function(error) {
                console.error("Erreur de géolocalisation :", error);
            }
        );
    </script>
    @include('admin.immos.stepJs')
        
@endsection