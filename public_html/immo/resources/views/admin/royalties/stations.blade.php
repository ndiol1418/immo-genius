@extends('layouts.admin')
@section('title',__('boutique.name'))

@section('actions')

@endsection

@section('content')
<div class="col-12">
    <div class="row">
        @include('admin.royalties.partials.filtre',['route'=>'royalties.station'])

        <div class="col-12 col-lg-3">
            <div class="row" id="ca">
                {{-- <div class="col-12">
                    <div class="jumbotron text-center p-4">
                        Chargement en cours ....
                    </div>
                </div> --}}
                @include('admin.royalties.partials.card-ca')
            </div>
        </div>
    </div>

</div>
<div class="col-12 col-md-12">
    <div class="row" id="wait">
        {{-- <div class="col-12">
            <div class="jumbotron text-center p-5">
                Chargement en cours ....
            </div>
        </div> --}}
        @include('admin.royalties.partials.liste-stations')
    </div>
</div>

    {{-- Datatable extension --}}
@endsection

@section('scriptBottom')
    {{-- @include('components.fragmentJs',['url'=>route('partials.listeStations'),"id"=>'wait']) --}}
    {{-- @include('components.fragmentJs',['url'=>route('partials.card-chiffre',[$debut,$fin]),"id"=>'ca']) --}}

    @include('partials.utilities.datatableElement', ['id' => 'datatable','paging'=>false])
    <script>
        $('.delete-station').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm(<?php echo json_encode(__('station.alert')); ?>)) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
