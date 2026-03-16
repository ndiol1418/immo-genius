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

    <!-- Chatbot flottant Vytimo -->
    <style>
    #vyt-chat-btn{position:fixed !important;bottom:30px !important;right:30px !important;z-index:99999 !important;width:60px;height:60px;background:#27E3C0;border-radius:50%;border:none;cursor:pointer;font-size:24px;box-shadow:0 4px 15px rgba(0,0,0,0.2);display:flex;align-items:center;justify-content:center;color:#fff;transition:transform .2s;}
    #vyt-chat-btn:hover{transform:scale(1.1);}
    #vyt-chat-win{position:fixed;bottom:82px;right:20px;width:300px;height:400px;background:#fff;border-radius:14px;box-shadow:0 8px 28px rgba(0,0,0,.15);display:flex;flex-direction:column;z-index:9998;overflow:hidden;transform:scale(0);transform-origin:bottom right;transition:transform .25s cubic-bezier(.34,1.56,.64,1);}
    #vyt-chat-win.open{transform:scale(1);}
    #vyt-chat-head{background:#27E3C0;color:#fff;padding:12px 14px;font-weight:700;font-size:13px;display:flex;justify-content:space-between;align-items:center;}
    #vyt-chat-head button{background:none;border:none;color:#fff;font-size:18px;cursor:pointer;line-height:1;}
    #vyt-chat-msgs{flex:1;overflow-y:auto;padding:10px;display:flex;flex-direction:column;gap:7px;background:#f8fffe;}
    .vyt-msg{max-width:85%;padding:7px 11px;border-radius:10px;font-size:12px;line-height:1.5;white-space:pre-wrap;word-break:break-word;}
    .vyt-msg.bot{background:#e8fdf8;border:1px solid #b2f5e8;align-self:flex-start;border-bottom-left-radius:2px;}
    .vyt-msg.usr{background:#27E3C0;color:#fff;align-self:flex-end;border-bottom-right-radius:2px;}
    #vyt-chat-foot{padding:8px;border-top:1px solid #e8fdf8;display:flex;gap:5px;background:#fff;}
    #vyt-chat-inp{flex:1;border:1px solid #ddd;border-radius:18px;padding:6px 12px;font-size:12px;outline:none;}
    #vyt-chat-inp:focus{border-color:#27E3C0;}
    #vyt-chat-send{background:#27E3C0;color:#fff;border:none;border-radius:50%;width:32px;height:32px;cursor:pointer;font-size:13px;flex-shrink:0;}
    </style>

    <button id="vyt-chat-btn" onclick="vytChatToggle()" title="Assistant Vytimo">💬</button>
    <div id="vyt-chat-win">
        <div id="vyt-chat-head">
            🏠 Assistant Vytimo
            <button onclick="vytChatToggle()">×</button>
        </div>
        <div id="vyt-chat-msgs"></div>
        <div id="vyt-chat-foot">
            <input id="vyt-chat-inp" type="text" placeholder="Votre question…" onkeydown="if(event.key==='Enter')vytSend()">
            <button id="vyt-chat-send" onclick="vytSend()">➤</button>
        </div>
    </div>
    <script>
    var vytOpen=false,vytGreeted=false;
    var vytFAQ=[
        {k:['publier','annonce','poster'],r:"Pour publier une annonce :\n1️⃣ Créez un compte agent\n2️⃣ Cliquez sur 'Publier'\n3️⃣ Remplissez les détails\n4️⃣ Ajoutez vos photos ✅"},
        {k:['contact','agent','appel'],r:"Pour contacter un agent :\n1️⃣ Ouvrez une annonce\n2️⃣ Cliquez sur '💬 Message'\n3️⃣ Rédigez votre message\n\nOu visitez : /agents 👥"},
        {k:['tarif','commission','prix','cout'],r:"Nos tarifs :\n• Commission : 2% sur les transactions\n• Annonces standards : gratuites\n• Pack premium : visibilité boostée 💚"},
        {k:['visite','360','virtuel'],r:"La visite 360° permet de visiter un bien depuis chez vous :\n• Photos panoramiques interactives\n• Compatible mobile 📱\nCherchez l'icône 🔄 sur les annonces !"},
        {k:['compte','inscription','creer','register'],r:"Pour créer un compte :\n1️⃣ Cliquez sur 'Se connecter'\n2️⃣ Choisissez votre profil\n3️⃣ Renseignez vos infos 📝\nC'est gratuit !"},
    ];
    function vytChatToggle(){
        vytOpen=!vytOpen;
        document.getElementById('vyt-chat-win').classList.toggle('open',vytOpen);
        if(vytOpen&&!vytGreeted){vytGreeted=true;setTimeout(function(){vytBot("Bonjour ! 👋 Je suis l'assistant Vytimo.\nComment puis-je vous aider ?");},300);}
    }
    function vytBot(t){var m=document.getElementById('vyt-chat-msgs');var d=document.createElement('div');d.className='vyt-msg bot';d.textContent=t;m.appendChild(d);m.scrollTop=m.scrollHeight;}
    function vytUsr(t){var m=document.getElementById('vyt-chat-msgs');var d=document.createElement('div');d.className='vyt-msg usr';d.textContent=t;m.appendChild(d);m.scrollTop=m.scrollHeight;}
    function vytSend(){
        var inp=document.getElementById('vyt-chat-inp');var t=inp.value.trim();if(!t)return;
        vytUsr(t);inp.value='';
        var l=t.toLowerCase(),found=false;
        for(var i=0;i<vytFAQ.length;i++){for(var j=0;j<vytFAQ[i].k.length;j++){if(l.indexOf(vytFAQ[i].k[j])!==-1){var r=vytFAQ[i].r;setTimeout(function(x){return function(){vytBot(x);};}(r),400);found=true;break;}}if(found)break;}
        if(!found)setTimeout(function(){vytBot("Je vous mets en contact avec un agent 👥\nVisitez : /agents");},400);
    }
    </script>
</body>
</html>
