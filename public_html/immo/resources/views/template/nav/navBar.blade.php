<style>
  .btn-style{
    width: 50% !important;
    height: 30px !important;
    padding: 2px !important;
    margin: 10px !important;
  }
  .header{box-shadow: none;}
</style>
@php
$full_url = url()->current();
$url_path = '/' . request()->path();
$explode_path = explode('/', $url_path);
$ref = isset($explode_path[1]) ? $explode_path[1] : null;
@endphp
<header id="header" class="header d-flex align-items-center fixed-top py-2" style="z-index: 10000">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
         <img src="{{ asset('img/logo.png') }}" alt="">
        {{-- <h1 class="sitename">VITTY<span>IMMO</span></h1> --}}
        {{-- <h1 class="sitename text-secondary">VYT<span>IMO</span></h1> --}}
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>

          <li><a href="/"  class="{{ $ref==''?'active':'' }}">Accueil</a></li>
          <li class=""><a href="{{ route('acheter') }}" class="{{ $ref=='acheter'?'active':'' }}">Acheter 
            {{-- <i class="bi bi-chevron-down toggle-dropdown"></i> --}}
          </a>
            {{-- <ul>
              @foreach($type_immos as $key => $type)
                <li><a href="{{ route('acheter',['type'=>$type->id,'hash'=>md5($type->id),'name'=>$type->name]) }}">{{ $type->name }}</a></li>
              @endforeach
            </ul> --}}
          </li>
          <li class=""><a href="{{ route('louer') }}" class="{{ $ref=='louer'?'active':'' }}">Louer 
            {{-- <i class="bi bi-chevron-down toggle-dropdown"></i> --}}
          </a>
            {{-- <ul>
              @foreach($type_immos as $key => $type)
                <li><a href="{{ route('louer',['type'=>$type->id,'hash'=>md5($type->id),'name'=>$type->name]) }}">{{ $type->name }}</a></li>
              @endforeach
            </ul> --}}
          </li>

          {{-- <li><a class="{{ $ref=='louer'?'active':'' }}" href="{{ route('louer') }}">Louer</a></li>
          <li><a class="{{ $ref=='acheter'?'active':'' }}" href="{{ route('acheter') }}">Acheter</a></li> --}}
          <li><a class="{{ $ref=='agents'?'active':'' }}" href="{{ route('agents') }}">Agent</a></li>
          <li><a class="{{ $ref=='faq'?'active':'' }}" href="{{ route('faq') }}">FAQ</a></li>
          <li><a class="{{ $ref=='calculateur-pret'?'active':'' }}" href="{{ route('calculateur') }}">Simulateur</a></li>
          <li><a class="{{ $ref=='estimation'?'active':'' }}" href="{{ route('estimation') }}">Estimation</a></li>

          @if (auth()->check())
            @php
              $navNonLus = \App\Models\Message::whereHas('conversation', fn($q) => $q->where('acheteur_id', auth()->id())->orWhere('agent_id', auth()->id()))
                ->where('sender_id', '!=', auth()->id())->where('lu', false)->count();
            @endphp
            <li><a href="{{ route('favoris.index') }}" class="d-flex align-items-center" style="gap:4px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 24 24" fill="#e74c3c"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54z"/></svg>
              Favoris
            </a></li>
            <li><a href="{{ route('messages.index') }}" class="d-flex align-items-center" style="gap:4px;position:relative;">
              <svg xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 24 24"><path fill="#27E3C0" d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2"/></svg>
              Messages
              @if($navNonLus > 0)
                <span style="background:#e74c3c;color:#fff;border-radius:50%;font-size:9px;padding:1px 5px;position:absolute;top:-4px;right:-8px;">{{ $navNonLus }}</span>
              @endif
            </a></li>
            <li><a href="{{ route('alertes.index') }}" class="d-flex align-items-center" style="gap:4px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 24 24"><path fill="#27E3C0" d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2m6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1z"/></svg>
              Alertes
            </a></li>
            @if(\App\Models\Fournisseur::where('user_id', auth()->id())->exists())
            <li><a href="{{ route('agent.analytics') }}" class="d-flex align-items-center" style="gap:4px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 24 24"><path fill="#27E3C0" d="M16 11.78L20.24 4.45L21.97 5.45L16.74 14.5L10.23 10.75L5.46 19H22V21H2V3H4V17.54L9.5 8Z"/></svg>
              Analytics
            </a></li>
            <li><a href="{{ route('gestion-locative.index') }}" class="d-flex align-items-center" style="gap:4px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 24 24"><path fill="#27E3C0" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m-7 14H7v-2h5zm5-4H7v-2h10zm0-4H7V7h10z"/></svg>
              Locatif
            </a></li>
            @endif
            <li>
              <a href="{{ route('login') }}" class="d-sm-block d-md-none _d-flex justify-content-start" style="gap: 10px">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M16 9a4 4 0 1 1-8 0a4 4 0 0 1 8 0m-2 0a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11s11-4.925 11-11S18.075 1 12 1M3 12c0 2.09.713 4.014 1.908 5.542A8.99 8.99 0 0 1 12.065 14a8.98 8.98 0 0 1 7.092 3.458A9 9 0 1 0 3 12m9 9a8.96 8.96 0 0 1-5.672-2.012A6.99 6.99 0 0 1 12.065 16a6.99 6.99 0 0 1 5.689 2.92A8.96 8.96 0 0 1 12 21"/></g></svg>
                <span class="text-dark">Espace Admin</span>
              </a>
            </li>
          @else
          {{-- <li><a href="{{ route('login') }}" class="d-block d-sm-none btn btn-xs btn-primary text-white mb-2 btn-style">Se connecter</a></li> --}}
          <li><a href="{{ route('inscriptions') }}" class="d-block d-sm-none btn btn-xs btn-secondary text-white btn-style">Se connecter</a></li>
          <li>
            @include('template.nav.btnNav',['css'=>'d-block d-sm-none'])

          </li>
            {{-- <li><a href="{{ route('login') }}" class="d-none d-sm-block d-md-none  btn btn-xs btn-primary text-white mb-2 btn-style" style="border-radius: 30px">Se connecter</a></li> --}}
            <li>
            @include('template.nav.btnNav',['css'=>'d-none d-sm-block d-md-none'])

            </li>
            <li><a href="{{ route('inscriptions') }}" class="d-none d-sm-block d-md-none  btn btn-xs btn-secondary text-white btn-style" style="border-radius: 30px">Se connecter</a></li>
            
            {{-- <li><a href="{{ route('login') }}" class="d-none d-md-block d-lg-none  btn btn-xs btn-primary text-white mb-2 btn-style" style="border-radius: 30px">Se connecter</a></li> --}}
            <li>
              @include('template.nav.btnNav',['css'=>'d-none d-md-block d-lg-none'])
            </li>
            <li><a href="{{ route('inscriptions') }}" class="d-none d-md-block d-lg-none  btn btn-xs btn-secondary text-white btn-style">Se connecter</a></li>
          @endif
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div class=" d-none d-md-block d-lg-none" style="gap: 10px">
        <div class="d-flex">
          @if (auth()->check())
            {{-- <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M16 9a4 4 0 1 1-8 0a4 4 0 0 1 8 0m-2 0a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11s11-4.925 11-11S18.075 1 12 1M3 12c0 2.09.713 4.014 1.908 5.542A8.99 8.99 0 0 1 12.065 14a8.98 8.98 0 0 1 7.092 3.458A9 9 0 1 0 3 12m9 9a8.96 8.96 0 0 1-5.672-2.012A6.99 6.99 0 0 1 12.065 16a6.99 6.99 0 0 1 5.689 2.92A8.96 8.96 0 0 1 12 21"/></g></svg>
              <span>Espace Admin</span>
            </a> --}}
            
          @else
            {{-- @if(!$is_inscription) --}}
              @include('template.nav.btnSeconnecter')
            {{-- @endif --}}
          @endif
        </div>
      </div>
      <div class="d-none d-sm-none d-md-block">
        <div class="d-flex" style="gap: 10px">
          @include('template.nav.btnNav')

          @if (auth()->check())
            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M16 9a4 4 0 1 1-8 0a4 4 0 0 1 8 0m-2 0a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11s11-4.925 11-11S18.075 1 12 1M3 12c0 2.09.713 4.014 1.908 5.542A8.99 8.99 0 0 1 12.065 14a8.98 8.98 0 0 1 7.092 3.458A9 9 0 1 0 3 12m9 9a8.96 8.96 0 0 1-5.672-2.012A6.99 6.99 0 0 1 12.065 16a6.99 6.99 0 0 1 5.689 2.92A8.96 8.96 0 0 1 12 21"/></g></svg>
              <span>Espace Admin</span>
            </a>
          @else
            @if(!$is_inscription)
              {{-- @include('template.nav.btnNav') --}}
              <a href="" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#staticBackdrop" style="border-radius: 11px">
                Se connecter
              </a>
              
              {{-- <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
                <span>Se connecter</span>
              </a> --}}

            @endif
          @endif
        </div>
      </div>

    </div>
  </header>