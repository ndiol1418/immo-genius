  <!-- Navbar -->
  <style>
    .dropdown-toggle::after {
        color: #e4032f !important;
    }
    .icon{
        width: 20px;
        padding: 0 2px;
    }
  </style>
  <nav class="main-header navbar text-sm navbar-expand navbar-white navbar-light"
    @if(isset($max))
        style="margin-left: 0;"
    @endif>
    <!-- Left navbar links -->
    <div class="site_info">
        <a href="/">
            <h1 class="h6 ml-2 font-weight-bold m-0 text-primary text-uppercase d-flex align-items-center text-sm">
              <span class="d-lg-none d-md-none mr-1"><img src="{{ asset('img/logo.png') }}" alt="" height="20" class="brand-image mr-2"> </span>
                {{-- {{ config('app.name', '') }} --}}
            </h1>
        </a>
    </div>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
        @if ($_user->role->profil->name == 'admin')
            <li class="nav-item dropdown">
                <a class="nav-link d-flex flex-nowrap align-items-center py-0 px-2" href="{{ route('admin.users.index') }}" title="Collaborateurs">
                    {{-- <span class="badge badge-danger navbar-badge">{{ count($_users) }}</span> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#dc3545" d="M12 5a3.5 3.5 0 0 0-3.5 3.5A3.5 3.5 0 0 0 12 12a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 12 5m0 2a1.5 1.5 0 0 1 1.5 1.5A1.5 1.5 0 0 1 12 10a1.5 1.5 0 0 1-1.5-1.5A1.5 1.5 0 0 1 12 7M5.5 8A2.5 2.5 0 0 0 3 10.5c0 .94.53 1.75 1.29 2.18c.36.2.77.32 1.21.32s.85-.12 1.21-.32c.37-.21.68-.51.91-.87A5.42 5.42 0 0 1 6.5 8.5v-.28c-.3-.14-.64-.22-1-.22m13 0c-.36 0-.7.08-1 .22v.28c0 1.2-.39 2.36-1.12 3.31c.12.19.25.34.4.49a2.48 2.48 0 0 0 1.72.7c.44 0 .85-.12 1.21-.32c.76-.43 1.29-1.24 1.29-2.18A2.5 2.5 0 0 0 18.5 8M12 14c-2.34 0-7 1.17-7 3.5V19h14v-1.5c0-2.33-4.66-3.5-7-3.5m-7.29.55C2.78 14.78 0 15.76 0 17.5V19h3v-1.93c0-1.01.69-1.85 1.71-2.52m14.58 0c1.02.67 1.71 1.51 1.71 2.52V19h3v-1.5c0-1.74-2.78-2.72-4.71-2.95M12 16c1.53 0 3.24.5 4.23 1H7.77c.99-.5 2.7-1 4.23-1"/></svg>
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 256"><path fill="#dc3545" d="M237 147.44a4 4 0 0 1-5.48-1.4c-8.33-14-20.93-22-34.56-22a4 4 0 0 1-1.2-.2a37 37 0 0 1-3.8.2a4 4 0 0 1 0-8a28 28 0 1 0-27.12-35a4 4 0 0 1-7.75-2a36 36 0 1 1 54 39.48c10.81 3.85 20.51 12 27.31 23.48a4 4 0 0 1-1.4 5.44M187.46 214a4 4 0 0 1-1.46 5.46a3.93 3.93 0 0 1-2 .54a4 4 0 0 1-3.46-2a61 61 0 0 0-105.08 0a4 4 0 0 1-6.92-4a68.35 68.35 0 0 1 39.19-31a44 44 0 1 1 40.54 0a68.35 68.35 0 0 1 39.19 31M128 180a36 36 0 1 0-36-36a36 36 0 0 0 36 36m-64-64a28 28 0 1 1 27.12-35a4 4 0 0 0 7.75-2a36 36 0 1 0-53.57 39.75a63.55 63.55 0 0 0-32.5 22.85a4 4 0 0 0 6.4 4.8A55.55 55.55 0 0 1 64 124a4 4 0 0 0 0-8"/></svg> --}}
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link d-flex flex-nowrap align-items-center py-0 px-2" data-toggle="dropdown" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#dc3545" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93c.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204s.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78c-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107c-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93c-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204s-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78c.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107s.71-.505.78-.929z"/><path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/></g></svg>
                {{-- <span class="badge badge-danger navbar-badge">0</span> --}}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="p-3 text-danger text-center">
                    {{ __('Configurations') }}
                </div>
                <a href="{{ route('admin.types.index') }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M8 12a4 4 0 1 0 0-8a4 4 0 0 0 0 8m2.61-4a2.61 2.61 0 1 1-5.22 0a2.61 2.61 0 0 1 5.22 0M8 5.246" clip-rule="evenodd"/></svg>

                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 21.327q-1.325 0-2.24-.915q-.914-.914-.914-2.239q0-1.184.756-2.057q.756-.872 1.898-1.049V12.5H6V8.904H3.596V3.096h5.808v5.808H7V11.5h10V8.856q-1.142-.177-1.898-1.05q-.756-.871-.756-2.056q0-1.324.915-2.24q.915-.914 2.24-.914t2.238.915t.915 2.239q0 1.185-.756 2.057T18 8.856V12.5h-5.5v2.567q1.142.177 1.898 1.05q.756.872.756 2.056q0 1.325-.915 2.24q-.915.914-2.24.914m5.505-13.423q.894 0 1.522-.632t.628-1.526t-.632-1.522t-1.526-.628t-1.522.632t-.628 1.526t.632 1.522t1.526.628m-12.908 0h3.808V4.096H4.596zm7.408 12.423q.894 0 1.522-.632t.628-1.526t-.632-1.522t-1.526-.628t-1.522.632t-.628 1.526t.632 1.522t1.526.628M12 18.173"/></svg> --}}
                    {{ __('menu.types') }}
                </a>
                <a href="{{ route('admin.type_biens.index') }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M8 12a4 4 0 1 0 0-8a4 4 0 0 0 0 8m2.61-4a2.61 2.61 0 1 1-5.22 0a2.61 2.61 0 0 1 5.22 0M8 5.246" clip-rule="evenodd"/></svg>

                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 21.327q-1.325 0-2.24-.915q-.914-.914-.914-2.239q0-1.184.756-2.057q.756-.872 1.898-1.049V12.5H6V8.904H3.596V3.096h5.808v5.808H7V11.5h10V8.856q-1.142-.177-1.898-1.05q-.756-.871-.756-2.056q0-1.324.915-2.24q.915-.914 2.24-.914t2.238.915t.915 2.239q0 1.185-.756 2.057T18 8.856V12.5h-5.5v2.567q1.142.177 1.898 1.05q.756.872.756 2.056q0 1.325-.915 2.24q-.915.914-2.24.914m5.505-13.423q.894 0 1.522-.632t.628-1.526t-.632-1.522t-1.526-.628t-1.522.632t-.628 1.526t.632 1.522t1.526.628m-12.908 0h3.808V4.096H4.596zm7.408 12.423q.894 0 1.522-.632t.628-1.526t-.632-1.522t-1.526-.628t-1.522.632t-.628 1.526t.632 1.522t1.526.628M12 18.173"/></svg> --}}
                    {{ __('menu.type_biens') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.type_immos.index') }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M8 12a4 4 0 1 0 0-8a4 4 0 0 0 0 8m2.61-4a2.61 2.61 0 1 1-5.22 0a2.61 2.61 0 0 1 5.22 0M8 5.246" clip-rule="evenodd"/></svg>

                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><path fill="currentColor" d="M13.5 11h-1.729L8.438 6H9.5l.5-.5v-4L9.5 1h-4l-.5.5v4l.5.5h1.062l-3.333 5H1.5l-.5.5v3l.5.5h3l.5-.5v-3l-.5-.5h-.068L7.5 6.4l3.068 4.6H10.5l-.5.5v3l.5.5h3l.5-.5v-3zM6 5V2h3v3zm-2 7v2H2v-2zm9 2h-2v-2h2z"/></svg> --}}
                    {{ __('menu.type_immos') }}
                </a>
                {{-- <div class="dropdown-divider"></div>
                <a href="{{ route('admin.type_locations.index') }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><path fill="currentColor" d="M13.5 11h-1.729L8.438 6H9.5l.5-.5v-4L9.5 1h-4l-.5.5v4l.5.5h1.062l-3.333 5H1.5l-.5.5v3l.5.5h3l.5-.5v-3l-.5-.5h-.068L7.5 6.4l3.068 4.6H10.5l-.5.5v3l.5.5h3l.5-.5v-3zM6 5V2h3v3zm-2 7v2H2v-2zm9 2h-2v-2h2z"/></svg>
                    {{ __('menu.type_locations') }}
                </a> --}}
          {{-- <div class="dropdown-divider"></div>
                <a href="{{ route('admin.departements.index') }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M18 22h-8a3 3 0 0 1-3-3v-1h1v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V8h1a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3m-6-6H4a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3h8a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3m0-1a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z"/></svg> 
                    {{ __('menu.departements') }}
                </a>       --}}
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.communes.index') }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M8 12a4 4 0 1 0 0-8a4 4 0 0 0 0 8m2.61-4a2.61 2.61 0 1 1-5.22 0a2.61 2.61 0 0 1 5.22 0M8 5.246" clip-rule="evenodd"/></svg>
                    {{ __('menu.communes') }}
                </a>
            </li>
        @endif

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown d-none">
            <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="p-3 text-danger text-center">
                Aucune notification !
            </div>
            {{-- <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> 4 new messages
                <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> 8 friend requests
                <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 3 new reports
                <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div> --}}
        </li>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" title="{{ isset($_user)?$_user->nom_complet:'' }}" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle d-flex flex-nowrap align-items-center py-0 px-2">
                {{-- <span class="text-primary"> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2"/><path d="M4.271 18.346S6.5 15.5 12 15.5s7.73 2.846 7.73 2.846M12 12a3 3 0 1 0 0-6a3 3 0 0 0 0 6"/></g></svg>
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#dc3545" stroke-linecap="round" stroke-width="1.5"><path stroke-linejoin="round" d="M13.477 21.245H8.34a4.918 4.918 0 0 1-5.136-4.623V7.378A4.918 4.918 0 0 1 8.34 2.755h5.136"/><path stroke-miterlimit="10" d="M20.795 12H7.442"/><path stroke-linejoin="round" d="m16.083 17.136l4.404-4.404a1.04 1.04 0 0 0 0-1.464l-4.404-4.404"/></g></svg> --}}
                    {{-- <i class="fas fa-sign-out-alt"></i> --}}
                {{-- </span> --}}
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow p-0" style="width: 260px;">
                <li class=""> <a href="{{ route('compte') }}" class="dropdown-item p-2"> <i class="fas fa-user text-danger icon"></i> Mon compte</a></li>
                <hr class="m-0">
                <li class="">
                    <a href="{{ route('logout') }}" class="dropdown-item p-2"
                        onclick="event.preventDefault();
                            if(confirm('Voulez-vous vraiment déconnecter votre compte ?')){
                                document.getElementById('logout-form').submit();
                            }
                            ">
                            <i class="fas fa-sign-out-alt text-danger icon"></i> Déconnexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>

        <li class="nav-item d-lg-none d-md-none">
            <a class="nav-link text-primary" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->
