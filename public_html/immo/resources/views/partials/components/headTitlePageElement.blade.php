<div class="d-sm-flex align-items-center justify-content-between">
    <h4 class="m-0 text-white-50 font-weight-lighter">@yield('subtitle')</h4>
    @if (isset($url))
        <a href="{{  url($url) }}" class="btn btn-xs btn-primary">{{ __('general.ajouter') }} <i class="fas fa-plus-circle ml-2"></i></a>
    @endif
    @if(isset($urlback))
        <a href="{{ $urlback != "" ? $urlback : url()->previous() }}" class="btn btn-xs btn-dark"><i class="fas fa-chevron-left ml-1"></i> {{ __('general.retour') }}</a>
    @endif
    @if(isset($edit))
        <a href="{{ route($route, $entity->id)  }}" class="btn btn-light btn-xs text-primary">
            <i class="fa fa-edit"></i> {{ __('general.modifier') }}
        </a>
    @endif
    @if(isset($isModal))
        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal">
            {{ __('general.ajouter') }} <i class="fas fa-plus-circle ml-2"></i>
        </button>
    @endif
    @if(isset($isModalImport))
        <button type="button" class="btn btn-xs btn-primary" style="width: 100px" data-toggle="modal" data-target="#exampleModal">
            {{ __('general.importer') }} <i class="fas fa-file-excel"></i>
        </button>
    @endif
</div>
