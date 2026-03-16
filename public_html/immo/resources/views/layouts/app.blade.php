<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Commande') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'E-Commande') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nom_complet }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <div id="vytimo-chatbot" style="position:fixed;bottom:30px;right:30px;z-index:999999;font-family:sans-serif;">
      <button id="chatbot-toggle" onclick="document.getElementById('chatbot-window').style.display = document.getElementById('chatbot-window').style.display === 'none' ? 'flex' : 'none'"
        style="width:60px;height:60px;border-radius:50%;background:#27E3C0;border:none;cursor:pointer;font-size:26px;box-shadow:0 4px 15px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;">
        💬
      </button>
      <div id="chatbot-window" style="display:none;flex-direction:column;position:absolute;bottom:70px;right:0;width:320px;height:420px;background:white;border-radius:16px;box-shadow:0 8px 30px rgba(0,0,0,0.2);overflow:hidden;">
        <div style="background:#27E3C0;padding:15px;color:white;font-weight:bold;font-size:14px;">
          🏠 Assistant Vytimo
          <button onclick="document.getElementById('chatbot-window').style.display='none'" style="float:right;background:none;border:none;color:white;font-size:18px;cursor:pointer;">✕</button>
        </div>
        <div id="chatbot-messages" style="flex:1;overflow-y:auto;padding:15px;display:flex;flex-direction:column;gap:10px;">
          <div style="background:#e8fdf9;padding:10px;border-radius:10px;font-size:13px;max-width:85%;">
            👋 Bonjour ! Je suis l'assistant Vytimo. Comment puis-je vous aider ?
          </div>
        </div>
        <div style="padding:10px;border-top:1px solid #eee;display:flex;gap:8px;">
          <input id="chatbot-input" type="text" placeholder="Votre message..."
            style="flex:1;padding:8px;border:1px solid #ddd;border-radius:20px;font-size:13px;outline:none;color:#333;background:#fff;"
            onkeypress="if(event.key==='Enter') sendChatMessage()">
          <button onclick="sendChatMessage()"
            style="background:#27E3C0;border:none;border-radius:50%;width:35px;height:35px;cursor:pointer;font-size:16px;">
            ➤
          </button>
        </div>
      </div>
    </div>
    <script>
    function sendChatMessage() {
      var input = document.getElementById('chatbot-input');
      var messages = document.getElementById('chatbot-messages');
      var text = input.value.trim();
      if (!text) return;
      messages.innerHTML += '<div style="background:#27E3C0;color:white;padding:10px;border-radius:10px;font-size:13px;max-width:85%;align-self:flex-end;margin-left:auto;">' + text + '</div>';
      input.value = '';
      var response = "Je vous mets en contact avec un agent → <a href='/agents' style='color:#27E3C0'>Voir les agents</a>";
      var t = text.toLowerCase();
      if (t.includes('publier') || t.includes('annonce')) response = "Pour publier une annonce, cliquez sur 'Publier une annonce' en haut de la page.";
      else if (t.includes('contact') || t.includes('agent')) response = "Pour contacter un agent, ouvrez une annonce et cliquez sur 'Message' ou 'Appeler'.";
      else if (t.includes('tarif') || t.includes('commission')) response = "Vytimo prend une commission de seulement 2% sur les transactions !";
      else if (t.includes('visite') || t.includes('360')) response = "La visite virtuelle est disponible sur certaines annonces. Cherchez le badge 'Visite Virtuelle'.";
      else if (t.includes('compte') || t.includes('inscription')) response = "Pour créer un compte, cliquez sur 'Se connecter' puis 'Inscription'. C'est gratuit !";
      setTimeout(function() {
        messages.innerHTML += '<div style="background:#e8fdf9;padding:10px;border-radius:10px;font-size:13px;max-width:85%;">' + response + '</div>';
        messages.scrollTop = messages.scrollHeight;
      }, 500);
      messages.scrollTop = messages.scrollHeight;
    }
    </script>
</body>
</html>
