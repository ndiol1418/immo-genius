@extends( ($_user->profil == 'superviseur') ? 'layouts.superviseur' : 'layouts.admin')
<style>
    #map { height: 500px}
    td{font-size: 12px}
</style>
@section('title',__('general.titre_biens'))

@section('actions')
    {{-- @if($_user->is_admin) --}}
        @include('partials.components.headTitlePageElement',['title'=>__('Nouveau'),'isModal'=>true])
    {{-- @endif --}}

@endsection

@section('content')
    <div class="col-lg-5">
        <div class="row" style="max-height: 582px;overflow:auto">
            @include('admin.biens.liste')
            @include('layouts.sub_layouts.datatable',['_classTableWrapper'=>'col-md-12'])
        </div>
    </div>
    <div class="col-12 col-lg-7">
        <div class="card shadow-none">
            <div class="card-body">
                <h3>{{ __('bien.carte') }}</h3>
                <div id="map"></div>
            </div>
        </div>
    </div>



    @include('admin.biens.modal')
    {{-- Datatable extension --}}

@endsection

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable','paging'=>false])

    <script>
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "AIzaSyCaSfdQyOwQoWtaDwtL5AMOm3eA492dg9M", v: "weekly"});
        </script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> --}}
    <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
    @include('admin.biens.script')


    <script>
        $(function() {
            @if (count($errors) > 0)
                $('#exampleModal').modal('show');
                // $('#editModal').modal('show');
            @endif
            $('body').on('click','.editModal',function() {
                $('#form').attr('action', $(this).attr('href'));
                $('#name').val($(this).data('nom'));
                $('#commune_id').val($(this).data('commune'));
                $('#type_id').val($(this).data('type_id'));
                $('#type_bien_id').val($(this).data('type_bien_id'));
                var gammes = $(this).data('gamme');
                $('#gamme').val(gammes).trigger('change');
                console.log(gammes);
                var zone = $(this).data('zone');
                $('#zone option[value='+zone+']').attr('selected','selected');
                // $('#gamme').select2('val', gammes).trigger('change');
                $('#gamme').val(gammes).trigger('change');
                var is_alcool = $(this).data('is_alcool');
                if (is_alcool == 0) {
                    $('#is_alcool option[value=0]').attr('selected', 'selected');
                } else {
                    $('#is_alcool option[value=1]').attr('selected', 'selected');
                }
            });
        });
    </script>

    <script src="{{ asset('js/partials/validationPassword.js') }}"></script>

@endsection
