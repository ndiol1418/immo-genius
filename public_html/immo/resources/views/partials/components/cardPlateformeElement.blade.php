<div class="plateform{{ !$plateforme->access || !$access ? ' opacity-5': '' }}">
    <div class="header d-flex flex-nowrap flex-start align-items-center pb-2">
        @if ($plateforme->logo)
            <img src="{{ asset($plateforme->logo) }}" alt="logo" class="mr-2">
        @endif
        <h2 class="m-0 title">
            {{ $plateforme->name }}
        </h2>
    </div>
    <p class="text pt-0 pb-1">
        {{ str_limit($plateforme->resume, 150) }}
    </p>
    <p class="footer d-flex d-inline justify-content-between align-items-center">
    <a href="{{ route('presentation', ['plateforme' => $plateforme, 'slug' => strtolower(str_slug($plateforme->name))]) }}" class="text-primary">En savoir + </a>
    @if ($access && $plateforme->access)
    <a href="{{ route('service.plateformes.redirection', $plateforme) }}" target="_blank" class="btn-sm btn-light"
        >Accéder <i class="fas fa-chevron-circle-right ml-2"></i></a>
    @endif
    </p>
</div>
