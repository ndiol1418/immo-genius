@php
   // dd($collaborateur->poste->name)
@endphp

<div class="col-md-12">
    <div class="card-body rounded bg-white">
        <div class="row _profile-wrapper" id="profile">
            <div class="col-md-12 user">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="nav nav-tabs" id="userTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link bg-danger" id="user-tab" data-toggle="tab"
                                    href="#user" role="tab" aria-controls="profile" aria-selected="false">Informations</a>
                            </li>
                        </ul>
                        <div class="row mt-2">
                            <div class="col-md-8 profil p-2">
                                <div class="tab-content profil_infos px-2 pb-4 w-100" id="myTabContent" style="overflow: auto">
                                    <div class="tab-pane fade show active" id="user" role="tabpanel"
                                        aria-labelledby="user-tab">
                                        @if (isset($user))
                                        <div class="profile-work mt-2 w-100">
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('general.prenom_nom') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $user->nom_complet }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('general.ad_mail') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $user->email ?? '---' }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center pb-3">
                                                <strong class="w-50">{{ __('general.telephone') }}</strong>
                                                <div class="text-left pl-2 w-50 bg-light rounded">{{ $user->telephone ?? '---' }}</div>
                                            </div>
                                            @if($user->role && $user->role->profil_id=2)
                                                <div class="d-flex justify-content-between align-items-center pb-3">
                                                    <strong class="w-50">Experience</strong>
                                                    <div class="text-left pl-2 w-50 bg-light rounded">{{ $user->fournisseur->experience ?? '---' }} mois</div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center pb-3">
                                                    <strong class="w-50">Zones d'interventions</strong>
                                                    @if (isset($user->fournisseur->zones) && count($user->fournisseur->zones))
                                                    @php
                                                        $zones = \App\Models\Commune::whereIn('id',$user->fournisseur->zones)->get();
                                                        
                                                    @endphp 
                                                        <div class="text-left pl-2 w-50 bg-light rounded">
                                                            @foreach ($zones as $zone)
                                                                <span class="badge badge-success">{{ $zone->name }}</span>
                                                            @endforeach
                                                        </div>
                                                        @else
                                                        <div class="text-left pl-2 w-50 bg-light rounded">---</div>
                                                    @endif

                                                </div>
                                                <div class="d-flex justify-content-between align-items-center pb-3">
                                                    <strong class="w-100">Biographie</strong>
                                                </div>
                                                <div class="text-left pl-2 w-100 bg-light rounded">{{ $user->fournisseur->bio ?? '---' }}</div>
                                            @endif

                                        </div>
                                        @else
                                            Aucune Information du collaborateur
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 d-flex justify-content-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <div style="height: 200px;width:200px;border-radius:10px;position: relative;overflow:hidden">
                                <img src="{{ asset($user->image?$user->image->url:'/img/avatar.png') }}" alt="" width="200px" height="200px" style="object-fit: cover">
                            </div>
                        </div>
                    </div>
                    {{-- @isset($collaborateur)
                        <div class="col-md-6 d-none">
                            <ul class="nav nav-tabs border-0 justify-content-end">
                                <li class="nav-item text-right">
                                    <a class="nav-link bold" disabled aria-selected="false">Profil</a>
                                </li>
                            </ul>
                            <div class="mt-2 w-100">
                                <div class="p-2 bg-light" style="border-radius: 8px">
                                    <div class="row justify-content-md-center">
                                        <div class="col-12 profil">
                                            <div class="profil_image mx-auto">
                                                <img src="/{{ old('collaborateur.photo') ?? isset($collaborateur->photo) ? env('CENTRALISATION_LINK').$collaborateur->photo : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGJ5W9rtnI5Yl0rQCZiNRUNjSqRH7zeouAIlJ3kJ-MBqNccffOkGcJvq7wcbatnzgxUo4&usqp=CAU' }}" alt="Profil"  id="img-logo" class="rounded mx-auto d-block photo" id="photo" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-12 text-center">
                                            <h5 class="text-muted text-md text-muted mb-0">
                                                {!! $user->nomComplet !!}
                                                @isset($collaborateur->poste)
                                                    -
                                                    <span class="text-info font-italic">{{ $collaborateur->poste->name }}</span>
                                                @endisset
                                            </h5>
                                            <div class="text-center">
                                                <span class="badge bg-white shadow-sm rounded p-2 text-uppercase">
                                                    <span class="text-primary"><i class="fas fa-user-clock"></i></span>
                                                    {{ $user->profil_name ?? 'non défini' }}
                                                </span>
                                                <span class="badge bg-white shadow-sm rounded p-2 text-uppercase">
                                                    <span class="text-primary">IGG</span>
                                                    {{ isset($collaborateur) ? $collaborateur->igg : 'non défini' }}
                                                </span>
                                                <span class="badge bg-white shadow-sm rounded p-2 text-uppercase">
                                                    <span class="text-uppercase text-primary">Matricule</span>
                                                    {{ isset($collaborateur) ? $collaborateur->matricule : 'non défini' }}
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset --}}

                </div>
            </div>
        </div>
    </div>
</div>
