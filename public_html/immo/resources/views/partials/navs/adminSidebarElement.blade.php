<style>
   .truncate {
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    li>a.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        background: #2E7D32;

        height: 100%;
        width: 10px;
        border-radius: 0 5px 5px 0;
        left: -15px;
    }
</style>
@php
$full_url = url()->current();
$url_path = '/' . request()->path();
$explode_path = explode('/', $url_path);
$ref = isset($explode_path[2]) ? $explode_path[2] : null;
//dd();
@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar text-sm elevation-0 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="/" class="brand-link bg-white d-flex justify-content-center align-items-center">
        <img src="{{ asset('img/logo-teranga.png') }}" alt="" class="brand-image">
        {{-- <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar border-0">
        <!-- Sidebar user (optional) -->
        <div class="mt-2 pb-2 mb-2 d-flex align-items-center px-2">
            <div class="image">
                <img src="{{ asset($_user->image?$_user->image->url:'/img/avatar.png') }}" style="height: 40px;width:40px;object-fit:cover;border: 1px solid #eee;" class="img-circle mr-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('compte') }}" class="brand-text font-weight-light titre_colab" title="{{ isset($_user)?$_user->nom_complet:'' }}" >

                    <div class="truncate"> {{ isset($_user)?$_user->nom_complet:'' }} </div>
                    <span class="badge badge-danger small">
                        {{-- <?= isset($_user) && $_user->is_admin?"Super'Admin":$_user->role->profil->name ?> --}}
                         {{ $_user->role->profil->name }}
                    </span>
                </a>
            </div>
        </div>
        @if (isset($_user) && in_array($_user->role->profil->name,['admin','fournisseur']))
            <nav class="mt-2 sidebar-nav" style="height: auto">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                        <a href="{{ route('inscriptions') }}" class="nav-link btn-primary text-white">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>
                                {{__('menu.new_annnonces')}}
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
        @endif
        <form method="GET" action="{{ route('search') }}" class="form-inline px-2 shadow-sm pb-2">
            <div class="input-group my-1 mt-2" data-widget="sidebar-search">
                <input class="form-control form-control-sm form-control-sidebar" name="search" type="text" value="{{ request()->query('search') }}" placeholder="Recherche"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-xs btn-sidebar bg-white">
                        <i class="fas fa-search text-primary fa-fw"></i>
                    </button>
                </div>
            </div>
        </form>
        <!-- Sidebar Menu -->
        <nav class="mt-2 sidebar-nav">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @if (isset($_sidebar))
                    @foreach ($_sidebar->principals as $key => $header)
                        @php
                            $url_principal = isset($header->url) ? url($header->url) : (isset($header->route) ? route($header->route) : '#');
                        @endphp
                        <li class="nav-item">
                            <a href="{{ $url_principal }}"
                                class="nav-link {{ $url_principal == $full_url ? 'active' : '' }}">
                                <i class="nav-icon fas {{ $header->fa }}"></i>
                                <p>
                                    <?= $header->name ?>
                                    @if (isset($header->variableCount))
                                        <span class="badge badge-primary right">{{ "${$header->variableCount}" ?? 0 }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                        <!-- Divider -->
                        <hr class="sidebar-divider my-0">
                    @endforeach
                    @foreach ($_sidebar->secondaires as $key => $second)
                        <!-- Nav Item - Utilities Collapse Menu -->
                        @if (isset($second->items) && count($second->items) > 0)
                            <li
                                class="nav-item {{ isset($second->refs) && in_array($ref, $second->refs) ? ' menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link{{ isset($second->refs) && in_array($ref, $second->refs) ? ' active' : '' }}">
                                    <i class="nav-icon fas {{ $second->fa }}"></i>
                                    <p>
                                        {{ $second->name }}
                                        <i class="right fas fa-angle-left"></i>
                                        @if (isset($second->variableCount))
                                            <span class="badge badge-primary right">{{ "${$second->variableCount}" ?? 0 }}</span>
                                        @endif
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if (isset($second->items) && count($second->items) > 0)

                                        @foreach ($second->items as $item)
                                            @php
                                                $itemUrl = isset($item->url) ? url($item->url, $item->params ?? []) : (isset($item->route) ? route($item->route, $item->params ?? []) : '#');
                                            @endphp
                                            <li class="nav-item">
                                                <a href="{{ $itemUrl }}"
                                                    class="nav-link{{ $itemUrl == $full_url ? ' active' : '' }}">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>
                                                        {{ $item->name }}
                                                        @if (isset($item->variableCount))
                                                            <span class="badge badge-primary right">{{ "${$item->variableCount}" ?? 0 }}</span>
                                                        @endif
                                                    </p>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif

                                </ul>
                            @else
                                @php
                                    $url_secondaire = isset($second->url) ? url($second->url) : (isset($second->route) ? route($second->route) : '#');
                                @endphp
                            <li class="nav-item">
                                <a href="{{ $url_secondaire }}"
                                    class="nav-link {{ $url_secondaire == $full_url ? 'active' : '' }}">
                                    <i class="nav-icon fas {{ $second->fa }}"></i>
                                    <p>
                                        {{ $second->name }}
                                        @if (isset($second->variableCount))
                                            <span class="badge badge-primary right">{{ "${$second->variableCount}" ?? 0 }}</span>
                                        @endif
                                    </p>
                                </a>
                        @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
