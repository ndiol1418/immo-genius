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
    .mr-1{
        margin-left: 4px
    }
    .tag{
        font-size: 12px
    }
</style>
<div class="{{ $col??'col-12' }}">
    <div class="_card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-lg-6">
                    <section id="hero" class="hero section dark-background">
                        <div id="hero-carousel-{{ $id??'' }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" style="min-height: 200px !important;">
    
                            <div class="carousel-item">
                            <img src="assets/img/properties/property-{{ $i }}.jpg" alt="">
                            </div>
                            <div class="carousel-item active">
                                <img src="assets/img/properties/property-{{ $i }}.jpg" alt="">
                            </div>
                            <a class="carousel-control-prev" href="#hero-carousel-{{ $id??'' }}" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                            </a>
                    
                            <a class="carousel-control-next" href="#hero-carousel-{{ $id??'' }}" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                            </a>
                    
                            <ol class="carousel-indicators"></ol>
                        </div>
                    </section>
                    {{-- <span>
                        <img src="{{ $img??'assets/img/properties/property-4.jpg' }}" class="img_annonce" alt="" width="100%">
                    </span> --}}
                </div>
                <div class="col-6 col-lg-6">
                    <br>
                    <span class="tag">{{ $tag??'Appartement' }}</span>
                    <p style="font-weight:bold">{{ number_format($montant??0,0,' ', ' ') }} cfa</p>
                    <p>{{ $titre??'Appartement 3 chambres' }}</p>
                    <div class="row">
                        <div class="col-12" style="position: absolute;bottom:10px">
                            <div class="d-flex">
                                <span class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="m12 17l1-2V9.858c1.721-.447 3-2 3-3.858c0-2.206-1.794-4-4-4S8 3.794 8 6c0 1.858 1.279 3.411 3 3.858V15zM10 6c0-1.103.897-2 2-2s2 .897 2 2s-.897 2-2 2s-2-.897-2-2"/><path fill="currentColor" d="m16.267 10.563l-.533 1.928C18.325 13.207 20 14.584 20 16c0 1.892-3.285 4-8 4s-8-2.108-8-4c0-1.416 1.675-2.793 4.267-3.51l-.533-1.928C4.197 11.54 2 13.623 2 16c0 3.364 4.393 6 10 6s10-2.636 10-6c0-2.377-2.197-4.46-5.733-5.437"/></svg></span>
                                <span>{{ $adresse??'Dakar, Senegal' }}</span>
                            </div>
                            <div class="d-flex" style="font-size: 12px">
                                <span class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="currentColor" d="M26 16H6a4 4 0 0 0-4 4v2a1 1 0 0 0 1 1h1v1a2 2 0 0 0 4 0v-1h16v1a2 2 0 0 0 4 0v-1h1a1 1 0 0 0 1-1v-2a4 4 0 0 0-4-4M9 10h5a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2m9 0h5a1 1 0 1 1 0 2h-5a1 1 0 1 1 0-2M7.009 14h17.982c.558 0 1.009-.451 1.009-1.009V8a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v4.991C6 13.549 6.451 14 7.009 14"/></svg>
                                    10
                                </span>
                                |
                                <span class="mr-1 ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="currentColor" d="M27 22.142V9.858A3.992 3.992 0 1 0 22.142 5H9.858A3.992 3.992 0 1 0 5 9.858v12.284A3.992 3.992 0 1 0 9.858 27h12.284A3.992 3.992 0 1 0 27 22.142M26 4a2 2 0 1 1-2 2a2 2 0 0 1 2-2M4 6a2 2 0 1 1 2 2a2 2 0 0 1-2-2m2 22a2 2 0 1 1 2-2a2 2 0 0 1-2 2m16.142-3H9.858A4 4 0 0 0 7 22.142V9.858A4 4 0 0 0 9.858 7h12.284A4 4 0 0 0 25 9.858v12.284A3.99 3.99 0 0 0 22.142 25M26 28a2 2 0 1 1 2-2a2.003 2.003 0 0 1-2 2"/></svg>
                                    10
                                </span>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>