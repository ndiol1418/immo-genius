<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page d'erreur</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('css/vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    {{-- <link href="{{ asset('css/frontend.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">

    {{-- FANCYBOX --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" integrity="sha256-ygkqlh3CYSUri3LhQxzdcm0n1EQvH2Y+U5S2idbLtxs=" crossorigin="anonymous" />

    <!-- Styles -->
    <link href="{{ asset('css/vendor/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/jquery.auto-complete.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/animate.min.css') }}" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.0-beta.3/iconify-icon.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" integrity="sha256-ygkqlh3CYSUri3LhQxzdcm0n1EQvH2Y+U5S2idbLtxs=" crossorigin="anonymous" />

    {{-- Reglage CSS ADMIN LTE --}}
</head>
<body class="bg-light" style="overflow:hidden">
    <div class="row justify-content-center vh-100">
        <div class="col-12" style="margin: auto 0">
            <div class="bg-light text-center">
                <img src="{{ asset('logo.png') }}" alt="">
                <h1 class="text-center">Page non trouvrée</h1>
                <p>Merci de contacter l'administrateur</p>
                <a href="" onclick="window.history.go(-1); return false;" class="text-white btn btn-primary ">
                    <i class="fa fa-chevron-left mr-2"></i> Retour
                </a>
            </div>
        </div>
    </div>
</body>
</html>