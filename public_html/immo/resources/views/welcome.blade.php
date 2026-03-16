@extends('layouts.accueil')
<style>
    label {
        font-size: 10px !important;
        margin-bottom: 0 !important
    }

</style>
@section('content')

<!-- Hero Section -->

<section id="hero" class="hero section dark-background" style="margin:0 5%;border-radius: 15px;margin-top: 100px;box-shadow: none; background-color: color-mix(in srgb, #fff, transparent 60%) !important;">

    <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" style="min-height: 60vh">

        <div class="carousel-item2 carousel-item active">
            <img src="{{ asset('img/home.jpeg') }}" alt="">
            <div class="carousel-container">
                <div>
                    <h2 class="text-dark text-center mb-1">Trouvez la maison où vous <br> allez aimer vivre! </h2>
                    <p class="text-center text-dark">Plateforme d’annonces immobilières pour tous</p>
                </div>
            </div>
        </div>

        {{-- <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
          </a>
  
          <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
          </a> --}}

        <ol class="carousel-indicators"></ol>

    </div>

</section><!-- /Hero Section -->
<div class="container d-none d-sm-block" style="padding: 0 60px;">
    @include('template.formulaire',['form'=>true])
</div>

<div class="container d-block d-sm-none">
    @include('template.filtre-mobile')
</div>

<!-- Services Section -->
@include('template.components.c_section_agents')
<section id="services" class="services section bg-light">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        {{-- <span class="text-center text-secondary">Premium</span> --}}
        <h3>Offres Premium</h3>
        {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
    </div><!-- End Section Title -->
    <div class="container">
        <div class="row">
            @foreach ($annonce_premium as $i=>$annonce)
            @include('template.components.c_annonce_2',[
            'montant'=> $annonce->prix,
            'col'=>$col??'col-lg-4 col-sm-4 col-12',
            'i'=>$i,
            'id'=>$i,
            'param'=>'CFA',
            'titre'=>$annonce->immo->name,
            'adresse'=>$annonce->immo?$annonce->immo->adresse.', '.$annonce->commune->name.', '.$annonce->commune->departement->name:$annonce->adresse,
            'icon'=>true
            ])
            @endforeach
        </div>

    </div>

</section><!-- /Services Section -->
<section id="services" class="services section">

    <div class="container">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-lg-3 col-sm-6 mb-4">
                    <h3><strong>Teranga Immobilier, c’est les meilleurs agents</strong></h3>
                    <span style="font-size: 12px">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas eget rutrum urna.</span>
                    @include('template.components.c_button',[
                    'title'=>'voir les agents ',
                    'bg'=>'dark border text-sm',
                    'size'=>50,
                    'is_btn'=>true,
                    'route'=>'agents',
                    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M4.5 11h11.586l-4.5-4.5L13 5.086L19.914 12L13 18.914L11.586 17.5l4.5-4.5H4.5z" /></svg>'
                    ])
                </div>
                <div class="col-12 col-lg-9 col-sm-12">
                    <div class="row">
                        @foreach ($agents as $i=>$agent)

                        <div class="col-6 col-lg-3 col-sm-4 mb-2">
                            @include('template.components.c_agent',[
                            'title'=>$agent->nom_complet,
                            'info'=>$agent->annonces->count()?'+'.$agent->annonces->count().' publication(s)':' aucune publication',
                            'img'=>$agent->picture!=null?$agent->picture:'img/user.png',
                            'tel'=>$agent->telephone
                            ])

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        {{-- <span class="text-center text-secondary">Récents</span> --}}
        <h3>Récemment postés</h3>
        {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
    </div><!-- End Section Title -->
    <div class="container">
        <div class="row">
            @include('template.pages.component-annonces',[
            'col'=>'col-lg-3 col-12 col-sm-4',
            'annonces'=>$annonce_news
            ])
        </div>

    </div>

</section><!-- /Services Section -->

<section id="recommandations" class="py-5">
  <div class="container">
    <div class="section-title mb-4" data-aos="fade-up">
      <h3>🤖 Recommandé pour vous</h3>
    </div>
    <div class="row">
      @foreach($annoncesRecommandees as $annonce)
        <div class="col-12 col-sm-6 col-lg-3">
          @include('template.components.card-annonce', ['annonce' => $annonce])
        </div>
      @endforeach
    </div>
  </div>
</section>

@include('template.pages.regions',['annonces'=>$annonce_zones])
<!-- Agents Section -->
<section id="agents" class="agents section mb-4">

    <!-- Section Title -->
    <div class="container section-title p-4 mb-4 radius-theme" data-aos="fade-up" style="text-align: center !important;padding:90px !important;background:#061630">
        <span class="text-left text-secondary">Vendez sur Teranga Immobilier</span>
        <h3 class="text-white">Etes-vous propriétaire ?</h3>
        <p class="text-white text-sm">Découvrez des moyens d'augmenter la valeur de votre maison et de la faire répertorier.</p>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-lg-4">
                <div class="d-flex bg-white mt-4" style="border-radius: 5px;padding:5px">
                    <input type="text" name="" id="" class="form-control radius-theme" placeholder="votre adresse email" style="border:none">
                    <button class="radius btn btn-dark p-1 w-50 text-secondary" style="background: #061630">
                        envoyer
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M4.5 11h11.586l-4.5-4.5L13 5.086L19.914 12L13 18.914L11.586 17.5l4.5-4.5H4.5z" /></svg>
                    </button>
                </div>
            </div>
        </div>
    </div><!-- End Section Title -->

</section><!-- /Agents Section -->

<!-- Testimonials Section -->
<section id="testimonials" class="testimonials section d-none">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
                {
                    "loop": true
                    , "speed": 600
                    , "autoplay": {
                        "delay": 5000
                    }
                    , "slidesPerView": "auto"
                    , "pagination": {
                        "el": ".swiper-pagination"
                        , "type": "bullets"
                        , "clickable": true
                    }
                    , "breakpoints": {
                        "320": {
                            "slidesPerView": 1
                            , "spaceBetween": 40
                        }
                        , "1200": {
                            "slidesPerView": 1
                            , "spaceBetween": 1
                        }
                    }
                }

            </script>
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                        </p>
                        <div class="profile mt-auto">
                            <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                            <h3>Saul Goodman</h3>
                            <h4>Ceo &amp; Founder</h4>
                        </div>
                    </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                        </p>
                        <div class="profile mt-auto">
                            <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                            <h3>Sara Wilsson</h3>
                            <h4>Designer</h4>
                        </div>
                    </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                        </p>
                        <div class="profile mt-auto">
                            <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                            <h3>Jena Karlis</h3>
                            <h4>Store Owner</h4>
                        </div>
                    </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                        </p>
                        <div class="profile mt-auto">
                            <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                            <h3>Matt Brandon</h3>
                            <h4>Freelancer</h4>
                        </div>
                    </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                        </p>
                        <div class="profile mt-auto">
                            <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                            <h3>John Larson</h3>
                            <h4>Entrepreneur</h4>
                        </div>
                    </div>
                </div><!-- End testimonial item -->

            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>

</section><!-- /Testimonials Section -->
@endsection

@section('scriptBottom')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaSfdQyOwQoWtaDwtL5AMOm3eA492dg9M&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
<script>
    let autocomplete;

    function initAutocomplete() {
        const address1Field = document.querySelector("#ship-address");
        if (!address1Field) return;

        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            componentRestrictions: { country: ["sn"] },
            fields: ["address_components", "geometry"],
            types: ["address"],
        });

        autocomplete.addListener("place_changed", fillInAddress);
    }

    function fillInAddress() {
        const place = autocomplete.getPlace();
        let address1 = "";
        let postcode = "";

        for (const component of place.address_components) {
            const type = component.types[0];
            switch (type) {
                case "street_number": address1 = `${component.long_name} ${address1}`; break;
                case "route":        address1 += component.short_name; break;
                case "postal_code":  postcode = component.long_name; break;
            }
        }

        const address1Field = document.querySelector("#ship-address");
        address1Field.value = address1 || place.formatted_address;
    }

    window.initAutocomplete = initAutocomplete;

</script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }

</script>
<script>
    $(function() {
        $("#password").on('change keyup', function(e) {
            var sanitizePassword = $(this).val().trim();
            $(this).val(sanitizePassword);
        });
    });

    var onloadCallback = function() {
        alert("grecaptcha is ready!");
    };

</script>
@endsection

<style>
    footer {
        height: 24px !important;
        position: fixed;
        width: 100%;
        bottom: 0;
        background-color: #f8f9fa;
    }

</style>
