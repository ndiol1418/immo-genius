<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', config('app.name'))</title>
  @yield('meta')

  <!-- Favicons -->
  {{-- <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}
  <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32" />
  <link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}" sizes="16x16" />
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="{{ asset("assets/biblio/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/biblio/bootstrap-icons/bootstrap-icons.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/biblio/aos/aos.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/biblio/fontawesome-free/css/all.min.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/biblio/swiper/swiper-bundle.min.css") }}" rel="stylesheet">
  <link rel="manifest" href="{{ asset('manifest.json') }}" />
  <link href="{{ asset('assets/css/map.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform">

  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   --}}
  
    <style>
    .bi-x::before {
        content: "\f62a";
        color: #000;
    }
        .nunito-<uniquifier> {
            font-family: "Nunito", sans-serif;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
        }
        .scroll-top {
            bottom: 66px !important;
        }
    .card{border: 1px solid #dee2e6 !important}
    .radius-theme{border-radius: 30px !important;overflow: hidden;}
    .form-control:focus{box-shadow: none !important}
    .text-sm{font-size: 12px}
    .img{
        height: 50px;
        width: 50px;
        border-radius: 50px;
        overflow: hidden;
    }
    footer{
        height: 24px !important;
        position: fixed;
        width: 100%;
        bottom: 0;
        background-color: #f8f9fa;
    }
    .hero .carousel-item:before {
      background: 
    color-mix(in srgb, #f8f9fa, transparent 60%) !important;
}
.premium{position:absolute;z-index: 10;border: 1px solid #fff;
        background: #06e5ca;
        font-size: 11px;
        border-radius: 10px;
        padding: 0 10px;
        top: 10;
        left: 10;
        display: flex;font-weight: bold
    }
.verifie{
    position: absolute;
    z-index: 10;
    border: 1px solid #fff;
    background: #fff;
    font-size: 11px;
    border-radius: 10px;
    padding: 0px 15px;
    top: 10;
    left: 10;
font-size: 10px;
    font-weight: bold;
    margin-top: 25px;
}
    ::-webkit-scrollbar {
        width: 0px;
        height: 0px;
    }

    ::-webkit-scrollbar-track {
        background: #fff;
        box-shadow: inset 0 0 1px #ccc;
        border-radius: 2px;
    }

    ::-webkit-scrollbar-thumb {
        background: #06e5ca;
        border-radius: 2px;
        /*box-shadow: inset 0 0 1px #ccc;*/
    }
    .col-form-label{font-size: 14px}
    </style>

  <!-- Main CSS File -->
  <link href="{{ asset("assets/css/style.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/css/main.css") }}" rel="stylesheet">
  <link href="{{ asset('css/biblio/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/step.css') }}" rel="stylesheet">
  <link href="{{ asset('css/inputFlotant.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: EstateAgency
  * Template URL: https://bootstrapmade.com/real-estate-agency-bootstrap-template/
  * Updated: Aug 09 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="contact-page">

    @include('template.nav.navBar',['is_inscription'=>isset($is_inscription)?true:false])

    <main>
        @yield('content')
    </main>

    @include('template.footer')

    <style>
            ul#suggestions {
      list-style: none;
      padding: 0;
      margin-top: 5px;
      border: 1px solid #f2f4f6;
      text-align: left;
      max-height: 200px;
      overflow-y: auto;
      background: white;
      position: relative;
      z-index: 2;
    }
    ul#suggestions li {
      padding: 8px;
      cursor: pointer;
      font-size: 12px;
    }
    ul#suggestions li:hover {
      background: #eee;
    }
 .btn-outline-secondary {
    --bs-btn-color: #071a5f !important;
    --bs-btn-border-color: #06e5ca !important;
    --bs-btn-hover-color: #fff !important;
    --bs-btn-hover-bg: #06e5ca !important;
    --bs-btn-hover-border-color: #06e5ca !important;
    --bs-btn-focus-shadow-rgb: 13, 110, 253 !important;
    --bs-btn-active-color: #fff !important;
    --bs-btn-active-bg: #06e5ca !important;
    --bs-btn-active-border-color: #06e5ca !important;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125) !important;
    --bs-btn-disabled-color: #06e5ca !important;
    --bs-btn-disabled-bg: transparent !important;
    --bs-btn-disabled-border-color: #06e5ca !important;
    --bs-gradient: none !important;
}
.form-check-input:checked {
    background-color: #06e5ca !important;
    border-color: #071a5f !important;
}
        @media (max-width: 768px) {
            .footer-navigation {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                z-index: 999;
                background-color: #fff;
                box-shadow:0 -2px 5px rgb(0 0 0 / 12%);
            }

            .footer-navigation ul {
                display: flex;
                justify-content: space-around;
                padding: 0;
                margin: 0;
                list-style: none;
            }

            .footer-navigation ul li {
                {{-- flex: 1; --}}
                text-align: center;
            }

            .footer-navigation ul li a {
                display: table-caption;
                padding: 10px;
                color: #333;
                text-decoration: none;
                font-size: 10px;
            }

          
        }

    </style>
    <!-- Menu Footer Fixe -->
    <div class="footer-navigation d-block d-sm-none">
        <ul>
            <li>
                <a href="/">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1"><path d="M5 12.76c0-1.358 0-2.037.274-2.634c.275-.597.79-1.038 1.821-1.922l1-.857C9.96 5.75 10.89 4.95 12 4.95s2.041.799 3.905 2.396l1 .857c1.03.884 1.546 1.325 1.82 1.922c.275.597.275 1.276.275 2.634V17c0 1.886 0 2.828-.586 3.414S16.886 21 15 21H9c-1.886 0-2.828 0-3.414-.586S5 18.886 5 17z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14.5 21v-5a1 1 0 0 0-1-1h-3a1 1 0 0 0-1 1v5"/></g></svg>
                Accueil
                </a>
            </li>
            <li><a href="/louer">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="m20.516 14.154l-6.362 6.362q-.245.242-.551.363t-.61.121t-.605-.121t-.546-.363L3.48 12.17q-.237-.217-.358-.518q-.121-.3-.121-.632V4.634q0-.674.472-1.154T4.635 3h6.386q.324 0 .629.131t.527.354l8.339 8.344q.25.245.364.551t.114.617t-.114.61t-.364.547m-7.075 5.654l6.361-6.362q.192-.192.192-.452t-.192-.452L11.266 4.02H4.635q-.27 0-.452.173Q4 4.366 4 4.635v6.38q0 .116.039.231q.038.116.134.212l8.364 8.35q.192.192.451.192q.26 0 .453-.192M6.55 7.558q.421 0 .714-.292t.294-.708q0-.425-.292-.722t-.708-.298q-.425 0-.722.295t-.297.717t.295.714t.716.294m5.489 4.48"/></svg>
            Louer</a></li>
            <li><a href="/louer">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 1024 1024"><path fill="currentColor" d="M704 288h131.072a32 32 0 0 1 31.808 28.8L886.4 512h-64.384l-16-160H704v96a32 32 0 1 1-64 0v-96H384v96a32 32 0 0 1-64 0v-96H217.92l-51.2 512H512v64H131.328a32 32 0 0 1-31.808-35.2l57.6-576a32 32 0 0 1 31.808-28.8H320v-22.336C320 154.688 405.504 64 512 64s192 90.688 192 201.664v22.4zm-64 0v-22.336C640 189.248 582.272 128 512 128s-128 61.248-128 137.664v22.4h256zm201.408 483.84L768 698.496V928a32 32 0 1 1-64 0V698.496l-73.344 73.344a32 32 0 1 1-45.248-45.248l128-128a32 32 0 0 1 45.248 0l128 128a32 32 0 1 1-45.248 45.248"/></svg>
            Acheter</a></li>
            <li><a href="/agents">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="6" r="4"/><path d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5Z" opacity="0.5"/></g></svg>
            
            Agents</a></li>
        </ul>
    </div>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>
  @include('loginModal')

  <!-- Vendor JS Files -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="{{ asset("assets/biblio/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
  <script src="{{ asset("assets/biblio/php-email-form/validate.js") }}"></script>
  <script src="{{ asset("assets/biblio/aos/aos.js") }}"></script>
  <script src="{{ asset("assets/biblio/swiper/swiper-bundle.min.js") }}"></script>
  <script src="{{ asset("assets/biblio/purecounter/purecounter_vanilla.js") }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="{{ asset('js/biblio/select2.min.js') }}"></script>
  <script>
        //Ajax form message
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if ($(".select").html() !== undefined) {
            $('.select2').select2();
        }
    </script>
    <script>
        window.onscroll = function() {
        var header = document.querySelector("header"); // Sélectionnez votre élément d'en-tête
        if (window.scrollY > 0) {
            // header.classList.add("fixed-top");
        } else {
            // header.classList.remove("fixed-top");
        }
    };
    </script>
    @yield('scriptBottom')
    @stack('subScript')
    <script>
            @if (count($errors) > 0)
                $('#staticBackdrop').modal('show');
            @endif
    </script>
</body>

</html>