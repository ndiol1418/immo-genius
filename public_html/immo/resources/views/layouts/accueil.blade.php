<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

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
  <meta name="theme-color" content="#2E7D32">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="Teranga">
  <link rel="apple-touch-icon" href="/img/logo-teranga.png">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="{{ asset("assets/biblio/swiper/swiper-bundle.min.css") }}" rel="stylesheet">
  <link rel="manifest" href="{{ asset('manifest.json') }}" />
  <link href="{{ asset('assets/css/map.css') }}" rel="stylesheet">

{{-- Styles Places Autocomplete : intégrés via PlaceAutocompleteElement (web component) --}}

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
        background: #2E7D32;
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
    background: #2E7D32;
    color: #fff;
    font-size: 10px;
    border-radius: 10px;
    padding: 0px 15px;
    top: 10;
    left: 10;
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
        background: #2E7D32;
        border-radius: 2px;
        /*box-shadow: inset 0 0 1px #ccc;*/
    }
    .col-form-label{font-size: 14px}
    /* Force thème clair global — bloque le rendu sombre natif du navigateur */
    :root {
        color-scheme: light only !important;
    }
    /* Fix champ Lieu (ship-address) */
    input#ship-address,
    input[id="ship-address"],
    input.pac-target-input,
    input[type="search"] {
        background-color: #ffffff !important;
        background: #ffffff !important;
        color: #333333 !important;
        color-scheme: light only !important;
        -webkit-text-fill-color: #333333 !important;
        -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
        box-shadow: 0 0 0 1000px #ffffff inset !important;
    }
    /* Fix autofill Chrome/Safari */
    input#ship-address:-webkit-autofill,
    input[id="ship-address"]:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
        -webkit-text-fill-color: #333333 !important;
    }
    /* Google Places Autocomplete dropdown */
    .pac-container {
        background-color: #fff !important;
        color: #333 !important;
        z-index: 9999 !important;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .pac-item {
        background-color: #fff !important;
        color: #333 !important;
        padding: 8px 12px;
        cursor: pointer;
    }
    .pac-item:hover {
        background-color: #f5f5f5 !important;
    }
    .pac-item-query {
        color: #333 !important;
    }
    </style>

  <!-- Pannellum — Photos 360° -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
  <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

  <!-- Main CSS File -->
  <link href="{{ asset("assets/css/style.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/css/main.css") }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
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

    {{-- ═══ Indicateur hors ligne ═══ --}}
    <div id="offline-indicator" style="display:none;position:fixed;top:0;left:0;right:0;z-index:99999;background:#dc3545;color:#fff;text-align:center;padding:7px;font-size:12px;font-weight:700;">
      📡 Mode hors ligne — Certaines fonctionnalités peuvent ne pas être disponibles
    </div>

    {{-- ═══ Bannière PWA ═══ --}}
    <div id="pwa-banner" style="display:none;position:fixed;bottom:70px;left:12px;right:12px;z-index:9990;background:#0d1c2e;color:#fff;border-radius:14px;padding:14px 16px;box-shadow:0 8px 32px rgba(0,0,0,.3);">
      <div style="display:flex;align-items:center;gap:12px;">
        <img src="/img/logo-teranga.png" style="width:44px;height:44px;border-radius:10px;object-fit:contain;background:#fff;padding:2px;">
        <div style="flex:1;">
          <div style="font-size:13px;font-weight:700;margin-bottom:2px;">📱 Installer l'application Teranga</div>
          <div style="font-size:11px;color:rgba(255,255,255,.7);">Accès rapide, mode hors ligne, notifications</div>
        </div>
        <button id="pwa-install-btn" onclick="installPWA()" style="background:#2E7D32;color:#fff;border:none;border-radius:8px;padding:8px 14px;font-size:12px;font-weight:700;cursor:pointer;white-space:nowrap;">
          Installer
        </button>
        <button onclick="dismissPWA()" style="background:none;border:none;color:rgba(255,255,255,.6);font-size:20px;cursor:pointer;padding:0 4px;line-height:1;">×</button>
      </div>
    </div>

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
    --bs-btn-border-color: #2E7D32 !important;
    --bs-btn-hover-color: #fff !important;
    --bs-btn-hover-bg: #2E7D32 !important;
    --bs-btn-hover-border-color: #2E7D32 !important;
    --bs-btn-focus-shadow-rgb: 13, 110, 253 !important;
    --bs-btn-active-color: #fff !important;
    --bs-btn-active-bg: #2E7D32 !important;
    --bs-btn-active-border-color: #2E7D32 !important;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125) !important;
    --bs-btn-disabled-color: #2E7D32 !important;
    --bs-btn-disabled-bg: transparent !important;
    --bs-btn-disabled-border-color: #2E7D32 !important;
    --bs-gradient: none !important;
}
.form-check-input:checked {
    background-color: #2E7D32 !important;
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
    {{-- ═══ Bottom Navigation Mobile ═══ --}}
    <nav class="d-block d-sm-none" id="bottom-nav" style="position:fixed;bottom:0;left:0;right:0;z-index:9980;background:#fff;box-shadow:0 -2px 12px rgba(0,0,0,.1);padding:0;">
      @php $curPath = request()->path(); @endphp
      <ul style="display:flex;list-style:none;margin:0;padding:0;">
        @php
          $navItems = [
            ['url'=>'/','label'=>'Accueil','icon'=>'<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round"/>','active'=>$curPath===''],
            ['url'=>'/acheter','label'=>'Rechercher','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>','active'=>in_array($curPath,['acheter','louer'])],
            ['url'=>'/favoris','label'=>'Favoris','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>','active'=>$curPath==='favoris'],
            ['url'=>auth()->check()?'/mon-profil-agent':'/inscriptions','label'=>'Profil','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>','active'=>in_array($curPath,['mon-profil-agent','inscriptions'])],
          ];
        @endphp
        @foreach($navItems as $item)
        <li style="flex:1;text-align:center;">
          <a href="{{ $item['url'] }}" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:8px 4px;text-decoration:none;color:{{ $item['active'] ? '#2E7D32' : '#888' }};font-size:10px;font-weight:{{ $item['active'] ? '700' : '500' }};gap:2px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="{{ $item['active'] ? '#2E7D32' : '#888' }}" stroke-width="1.8">
              {!! $item['icon'] !!}
            </svg>
            {{ $item['label'] }}
          </a>
        </li>
        @endforeach
      </ul>
    </nav>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>
  @include('loginModal')
  @include('comparaison.floating_bar')
  @include('chatbot.widget')

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
    <script>
    // ─── Service Worker + PWA ─────────────────────────────
    let deferredPrompt = null;

    window.addEventListener('beforeinstallprompt', e => {
      e.preventDefault();
      deferredPrompt = e;
      if (!localStorage.getItem('pwa-dismissed')) {
        setTimeout(() => { document.getElementById('pwa-banner').style.display = 'block'; }, 3000);
      }
    });

    window.addEventListener('appinstalled', () => {
      document.getElementById('pwa-banner').style.display = 'none';
      localStorage.setItem('pwa-dismissed', '1');
    });

    function installPWA() {
      if (!deferredPrompt) return;
      deferredPrompt.prompt();
      deferredPrompt.userChoice.then(r => {
        if (r.outcome === 'accepted') localStorage.setItem('pwa-dismissed', '1');
        document.getElementById('pwa-banner').style.display = 'none';
        deferredPrompt = null;
      });
    }

    function dismissPWA() {
      document.getElementById('pwa-banner').style.display = 'none';
      localStorage.setItem('pwa-dismissed', '1');
    }

    // ─── Service Worker registration ─────────────────────
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/sw.js').catch(function(){});
    }

    // ─── Offline indicator ────────────────────────────────
    function updateOnlineStatus() {
      const el = document.getElementById('offline-indicator');
      if (el) el.style.display = navigator.onLine ? 'none' : 'block';
    }
    window.addEventListener('online',  updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
    updateOnlineStatus();
    </script>

    {{-- Mobile CSS improvements --}}
    <style>
    @media (max-width: 576px) {
      /* Inputs plus grands sur mobile */
      .form-control, select.form-control, input.form-control { min-height: 48px !important; font-size: 16px !important; }
      .btn { min-height: 44px; }
      /* Padding bas pour le bottom nav */
      main { padding-bottom: 70px !important; }
      footer { margin-bottom: 60px !important; }
      /* Cartes annonces en liste sur mobile */
      .row.annonces-grid > [class*="col-"] { padding-left: 8px !important; padding-right: 8px !important; }
      /* Swiper photos */
      .swiper-container { border-radius: 12px; overflow: hidden; }
      /* Header caché partiellement sur très petit écran */
      #header { padding: 4px 0 !important; }
    }
    </style>

</body>

</html>