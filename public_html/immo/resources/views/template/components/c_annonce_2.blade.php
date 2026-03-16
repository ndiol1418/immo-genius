<style>
    .img_annonce{
        height: 160px;
        position: relative;
        max-width: 100%;
        max-height: 100%;
    }
    .mr-1{
        margin-right: 4px
    }
    .ml-1{
        margin-left: 4px
    }
    .tag{
        font-size: 12px;
    }
    p{margin-bottom: 1px}
    span>svg::after{font-size: 10px}
    .text-xs{font-size: 10px}
    /* .component{margin-bottom: 25px} */

</style>
@php
    $adresse= $annonce->immo&&$annonce->immo->bien?$annonce->immo->bien->adresse.', '.$annonce->commune->name.', '.$annonce->commune->departement->name:$annonce->adresse;
@endphp

<div class="{{ $col??'col-12' }} component checkShop"                 
    data-lat ="{{ $annonce->immo->bien?$annonce->immo->bien->lat:0 }}"
    data-nom ="{{ $annonce->immo->bien?$annonce->immo->bien->name:'' }}"
    data-image ="{{ $annonce->images && count($annonce->images)?$annonce->images[0]->url:'' }}"
    data-montant ="{{ number_format($annonce->prix,0,'',' ').' CFA' }}"
    data-adresse ="{{ $annonce->immo->bien?$annonce->immo->bien->adresse:'' }}"
    data-lon ="{{ $annonce->immo->bien?$annonce->immo->bien->lon:''  }}">
    <div class="_card mb-4 border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if($annonce->is_premium)
                        <div class="premium d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#fff" d="m12 11.675l-1.565 1.223q-.131.087-.252.003t-.071-.22l.592-1.985l-1.558-1.13q-.125-.087-.065-.23t.196-.144h1.939l.592-1.973q.05-.136.192-.136t.192.136l.593 1.973h1.932q.137 0 .2.143t-.063.23l-1.563 1.131l.592 1.985q.05.136-.071.22t-.252-.003zm0 8.287l-3.963 1.184q-.385.137-.711-.115T7 20.375v-5.504q-.95-.934-1.475-2.188T5 10q0-2.927 2.036-4.963T12 3t4.964 2.036T19 10q0 1.429-.525 2.683T17 14.87v5.504q0 .404-.326.656t-.71.115zM12 16q2.5 0 4.25-1.75T18 10t-1.75-4.25T12 4T7.75 5.75T6 10t1.75 4.25T12 16m-4 4.044l4-1.121l4 1.121v-4.33q-.836.615-1.859.95Q13.12 17 12 17t-2.141-.335T8 15.714zm4-2.165"/></svg>
                            <span>Premium</span>
                        </div>
                    @else
                        @if($annonce->is_new)
                            
                            <div class="premium d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#fff" d="m12 11.675l-1.565 1.223q-.131.087-.252.003t-.071-.22l.592-1.985l-1.558-1.13q-.125-.087-.065-.23t.196-.144h1.939l.592-1.973q.05-.136.192-.136t.192.136l.593 1.973h1.932q.137 0 .2.143t-.063.23l-1.563 1.131l.592 1.985q.05.136-.071.22t-.252-.003zm0 8.287l-3.963 1.184q-.385.137-.711-.115T7 20.375v-5.504q-.95-.934-1.475-2.188T5 10q0-2.927 2.036-4.963T12 3t4.964 2.036T19 10q0 1.429-.525 2.683T17 14.87v5.504q0 .404-.326.656t-.71.115zM12 16q2.5 0 4.25-1.75T18 10t-1.75-4.25T12 4T7.75 5.75T6 10t1.75 4.25T12 16m-4 4.044l4-1.121l4 1.121v-4.33q-.836.615-1.859.95Q13.12 17 12 17t-2.141-.335T8 15.714zm4-2.165"/></svg>
                                <span>Nouveau</span>
                            </div>
                        @endif
                    @endif
                    @if($annonce->is_verify || $annonce->is_premium)
                        <div class="verifie d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#fff" fill-rule="evenodd" d="M15.418 5.643a1.25 1.25 0 0 0-1.34-.555l-1.798.413a1.25 1.25 0 0 1-.56 0l-1.798-.413a1.25 1.25 0 0 0-1.34.555l-.98 1.564c-.1.16-.235.295-.395.396l-1.564.98a1.25 1.25 0 0 0-.555 1.338l.413 1.8a1.25 1.25 0 0 1 0 .559l-.413 1.799a1.25 1.25 0 0 0 .555 1.339l1.564.98c.16.1.295.235.396.395l.98 1.564c.282.451.82.674 1.339.555l1.798-.413a1.25 1.25 0 0 1 .56 0l1.799.413a1.25 1.25 0 0 0 1.339-.555l.98-1.564c.1-.16.235-.295.395-.395l1.565-.98a1.25 1.25 0 0 0 .554-1.34L18.5 12.28a1.25 1.25 0 0 1 0-.56l.413-1.799a1.25 1.25 0 0 0-.554-1.339l-1.565-.98a1.25 1.25 0 0 1-.395-.395zm-.503 4.127a.5.5 0 0 0-.86-.509l-2.615 4.426l-1.579-1.512a.5.5 0 1 0-.691.722l2.034 1.949a.5.5 0 0 0 .776-.107z" clip-rule="evenodd"/></svg>
                            <span>Verifié</span>
                        </div>
                    @endif
                    @php $isFavori = auth()->check() ? \App\Models\Favori::where('user_id', auth()->id())->where('annonce_id', $annonce->id)->exists() : false; @endphp
                    <button onclick="toggleFavori(event, {{ $annonce->id }}, this)"
                        data-favori="{{ $isFavori ? '1' : '0' }}"
                        style="position:absolute;top:10px;right:10px;z-index:10;background:rgba(255,255,255,.9);border:none;border-radius:50%;width:34px;height:34px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,.15);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="{{ $isFavori ? '#e74c3c' : 'none' }}"
                            stroke="{{ $isFavori ? '#e74c3c' : '#999' }}" stroke-width="2">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54z"/>
                        </svg>
                    </button>
                    {{-- Bouton Comparer --}}
                    <button onclick="toggleCompare({{ $annonce->id }}, '{{ addslashes($annonce->name) }}', this)"
                        data-compare-id="{{ $annonce->id }}" data-compare-btn
                        title="Comparer"
                        style="position:absolute;top:10px;left:10px;z-index:10;background:rgba(255,255,255,.9);border:none;border-radius:50%;width:34px;height:34px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,.15);font-size:16px;">
                        ⚖️
                    </button>
                    <section id="hero" class="hero section dark-background" style="border-radius: 20px">
                        <div id="hero-carousel-{{ $id??'' }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" style="min-height: 250px !important;">
                            @isset($annonce)
                                @foreach($annonce->images as $key => $image)
                                    <div class="carousel-item {{ $key == 0 ?'active':'' }}">
                                        <img src="{{ asset($image->url) }}" alt="">
                                    </div>
                                @endforeach
                            @endisset

                            <ol class="carousel-indicators"></ol>
                        </div>
                    </section>
                </div>
                <div class="col-12">
                    {{-- <span class="tag mt-2">{{ $tag??'Appartement' }}</span> --}}
                    <a href="{{ route('annonce',$annonce->slug) }}">
                        <div class="p-2">
                            <div class="card-body">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col">
                                        <p style="font-weight:bold;">{{ number_format($montant??0,0,' ', ' ') }} {{ $param??'CFA' }}</p>
                                        {{-- <p>{{ $titre??'---' }}</p> --}}
                                    </div>
                                    @isset($icon)
                                        <div class="col">
                                            <div class="img" style="float: right">
                                                <img src="{{ asset($annonce->fournisseur?$annonce->fournisseur->picture:'img/user.png') }}" alt="" width="100%" style="height:40px;width:40px;object-fit:cover;">
                                            </div>
                                        </div>
                                    @endisset
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex">
                                            <span class="mr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 256 256"><path fill="currentColor" d="M128 64a40 40 0 1 0 40 40a40 40 0 0 0-40-40m0 64a24 24 0 1 1 24-24a24 24 0 0 1-24 24m0-112a88.1 88.1 0 0 0-88 88c0 31.4 14.51 64.68 42 96.25a254.2 254.2 0 0 0 41.45 38.3a8 8 0 0 0 9.18 0a254.2 254.2 0 0 0 41.37-38.3c27.45-31.57 42-64.85 42-96.25a88.1 88.1 0 0 0-88-88m0 206c-16.53-13-72-60.75-72-118a72 72 0 0 1 144 0c0 57.23-55.47 105-72 118"/></svg>
                                            </span>
                                            <span style="font-size: 12px;    white-space: nowrap;
                                            text-overflow: ellipsis;
                                            overflow: hidden;">{{ $adresse??'Dakar, Senegal' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center" style="font-size: 12px;height:30px">
                                            @isset ($annonce)
                                                @if($annonce->pieces)
                                                    
                                                    @for($i = 1; $i <= count($annonce->pieces); $i++)
                                                        @foreach ($annonce->pieces[$i] as $k => $v)
                                                            <span class="mr-1">
                                                                @if ($i == 1)
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 32 32"><path fill="currentColor" d="M26 16H6a4 4 0 0 0-4 4v2a1 1 0 0 0 1 1h1v1a2 2 0 0 0 4 0v-1h16v1a2 2 0 0 0 4 0v-1h1a1 1 0 0 0 1-1v-2a4 4 0 0 0-4-4M9 10h5a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2m9 0h5a1 1 0 1 1 0 2h-5a1 1 0 1 1 0-2M7.009 14h17.982c.558 0 1.009-.451 1.009-1.009V8a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v4.991C6 13.549 6.451 14 7.009 14"/></svg>
                                                                @endif
                                                                @if ($i == 2)
                                                                    |<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 32 32"><path fill="currentColor" d="M27 22.142V9.858A3.992 3.992 0 1 0 22.142 5H9.858A3.992 3.992 0 1 0 5 9.858v12.284A3.992 3.992 0 1 0 9.858 27h12.284A3.992 3.992 0 1 0 27 22.142M26 4a2 2 0 1 1-2 2a2 2 0 0 1 2-2M4 6a2 2 0 1 1 2 2a2 2 0 0 1-2-2m2 22a2 2 0 1 1 2-2a2 2 0 0 1-2 2m16.142-3H9.858A4 4 0 0 0 7 22.142V9.858A4 4 0 0 0 9.858 7h12.284A4 4 0 0 0 25 9.858v12.284A3.99 3.99 0 0 0 22.142 25M26 28a2 2 0 1 1 2-2a2.003 2.003 0 0 1-2 2"/></svg>
                                                                @endif
                                                                @if ($i == 3)
                                                                    | <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M21 14v1c0 1.91-1.07 3.57-2.65 4.41L19 22h-2l-.5-2h-9L7 22H5l.65-2.59A4.99 4.99 0 0 1 3 15v-1H2v-2h18V5a1 1 0 0 0-1-1c-.5 0-.88.34-1 .79c.63.54 1 1.34 1 2.21h-6a3 3 0 0 1 3-3h.17c.41-1.16 1.52-2 2.83-2a3 3 0 0 1 3 3v9zm-2 0H5v1a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3z"/></svg>
                                                                @endif
                                                                {{-- @if ($i == 4)
                                                                    | <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M21 9V7c0-1.65-1.35-3-3-3h-4c-.77 0-1.47.3-2 .78c-.53-.48-1.23-.78-2-.78H6C4.35 4 3 5.35 3 7v2c-1.65 0-3 1.35-3 3v5c0 1.65 1.35 3 3 3v2h2v-2h14v2h2v-2c1.65 0 3-1.35 3-3v-5c0-1.65-1.35-3-3-3m-7-3h4c.55 0 1 .45 1 1v2.78c-.61.55-1 1.34-1 2.22v2h-5V7c0-.55.45-1 1-1M5 7c0-.55.45-1 1-1h4c.55 0 1 .45 1 1v7H6v-2c0-.88-.39-1.67-1-2.22zm17 10c0 .55-.45 1-1 1H3c-.55 0-1-.45-1-1v-5c0-.55.45-1 1-1s1 .45 1 1v4h16v-4c0-.55.45-1 1-1s1 .45 1 1z"/></svg>                                                        
                                                                @endif --}}
                                                                @if ($i<4)
                                                                    
                                                                <span class="text-xs">{{ $v??0 }}</span>
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                    @endfor
                                                @endif
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@once
<script>
function toggleFavori(e, annonceId, btn) {
    e.preventDefault();
    e.stopPropagation();
    @if(!auth()->check())
        window.location.href = '{{ route("login") }}';
        return;
    @endif
    fetch('{{ url("/favoris/toggle") }}/' + annonceId, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        const svg = btn.querySelector('svg');
        if (data.status === 'added') {
            svg.setAttribute('fill', '#e74c3c');
            svg.setAttribute('stroke', '#e74c3c');
            btn.setAttribute('data-favori', '1');
        } else {
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', '#999');
            btn.setAttribute('data-favori', '0');
        }
    });
}
</script>
@endonce

{{-- @push('subScript')
    <script>
        $(function() {
            $('.checkShop').click(function(){
                var title = $(this).value('nom')
                var adresse = $(this).data('adresse')
                var lon = $(this).data('lon');
                var lat = $(this).data('lat');
                var adresse = $(this).data('adresse');
                var montant = $(this).data('montant');
                var bien = $(this).data('bien');
                console.log(lon)
                placeMarkerAndPanTo({lat:lat,lng:lon},map);
    
                var infoWindow = new google.maps.InfoWindow();
                var windowLatLng = new google.maps.LatLng(lat,lon);
                infoWindow.setOptions({
                    content: "<div>"+title+"</div><br><strong>Adresse: </strong>"+adresse+"<br><strong>Prix: </strong>"+montant+"<br><strong>bien: </strong>"+bien,
                    position: windowLatLng,
                });
                infoWindow.open(map);
            });
        })
</script>
@endpush --}}