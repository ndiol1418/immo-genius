
<div class="col-md-12">
    <div class="card-body rounded bg-white">
        <div class="row profile-wrapper" id="profile">
            <div class="col-md-12 user">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="userTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="user-tab" data-toggle="tab"
                                    href="#user" role="tab" aria-controls="profile" aria-selected="false">Informations du founisseur: <strong> {{ $fournisseur->nom }}</strong> </a>
                            </li>
                        </ul>
                        <div class="row mt-2">
                            <div class="col-md-8 profil p-2">
                                <div class="tab-content profil_infos px-2 pb-4 w-100" id="myTabContent" style="overflow: auto">
                                    <div class="tab-pane fade show active" id="user" role="tabpanel"
                                        aria-labelledby="user-tab">
                                        @if (isset($fournisseur))
                                        <div class="profile-work mt-2 w-100">
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('fournisseur.nom') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $fournisseur->nom }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('fournisseur.contact') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $fournisseur->contact ?? '---' }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('fournisseur.telephone') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $fournisseur->telephone ?? '---' }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('fournisseur.adresse') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $fournisseur->adresse ?? '---' }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('fournisseur.email') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $fournisseur->email ?? '---' }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('fournisseur.taux_royalties') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $fournisseur->taux_royalties ?? '---' }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('fournisseur.tva') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $fournisseur->tva.' %' ?? '---' }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('fournisseur.code') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $fournisseur->code ?? '---' }}</div>
                                            </div>
                                        </div>
                                        @else
                                            Aucune Information du fournisseur
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
