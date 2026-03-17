<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'E-COMMANDE') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}" sizes="16x16" />
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" >
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <link rel="manifest" href="{{ asset('manifest.json') }}" />
    </head>
    <body>

        <div id="login-container" class="p-2 d-flex justify-content-center align-items-center"  >
            @yield('content')
            <!-- Main Footer -->
        </div>
        <footer class="main-footer shadow-sm mt-1">
            <div class="d-flex justify-content-between align-items-center ">
                <strong class="w-50 ml-2">Copyright &copy; {{ now()->format('Y') }}</strong>
                <strong class="text-right mr-2 w-50 bg-light "> {{ env('APP_NAME') }}</strong>
            </div>

        </footer>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/config-vendor.js') }}"></script>
        <script src="{{ asset('js/partials/showHidePassword.js') }}"></script>
            @yield('scriptBottom')
    </body>
</html>

<style>
    #login-container{
        background-color: #2E7D32;
        background-image: linear-gradient(135deg, #2E7D32 0%, #1B5E20 100%);
        background-repeat: no-repeat;
        background-size: cover;
        height: calc(100vh - 28px);
    }
</style>
