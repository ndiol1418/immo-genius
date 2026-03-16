@extends('layouts.accueil')
<link href="{{ asset("assets/css/agent.css") }}" rel="stylesheet">

@php
    $agentPhoto   = $agent->user->image ? asset($agent->user->image->url) : asset('img/agent-default.png');
    $zonesNoms    = $agent->mes_zones()->pluck('name')->implode(', ');
    $bioText      = Str::limit(strip_tags($agent->bio ?? $agent->description ?? ''), 155)
                    ?: "Agent immobilier spécialisé à {$zonesNoms}. Contactez {$agent->nom_complet} pour vos projets d'achat ou de location.";
    $keywordsAgent = implode(', ', array_filter([
        $agent->nom_complet,
        'agent immobilier',
        $zonesNoms,
        'immobilier Sénégal',
        config('app.name'),
    ]));
    $canonicalUrl = $url ?? request()->fullUrl();
@endphp

@section('title', $agent->nom_complet . ' — Agent immobilier' . ($zonesNoms ? ' · ' . Str::limit($zonesNoms, 50) : '') . ' | ' . config('app.name'))

@section('meta')
    {{-- Description & Keywords --}}
    <meta name="description" content="{{ $bioText }}">
    <meta name="keywords" content="{{ $keywordsAgent }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="profile">
    <meta property="og:site_name"   content="{{ config('app.name') }}">
    <meta property="og:url"         content="{{ $canonicalUrl }}">
    <meta property="og:title"       content="{{ $agent->nom_complet }} — Agent immobilier | {{ config('app.name') }}">
    <meta property="og:description" content="{{ $bioText }}">
    <meta property="og:image"       content="{{ $agentPhoto }}">
    <meta property="og:image:alt"   content="Photo de {{ $agent->nom_complet }}">
    <meta property="og:locale"      content="fr_SN">
    <meta property="profile:first_name" content="{{ $agent->prenom ?? '' }}">
    <meta property="profile:last_name"  content="{{ $agent->nom ?? '' }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary">
    <meta name="twitter:title"       content="{{ $agent->nom_complet }} — Agent immobilier | {{ config('app.name') }}">
    <meta name="twitter:description" content="{{ $bioText }}">
    <meta name="twitter:image"       content="{{ $agentPhoto }}">

    {{-- Schema.org Person --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "RealEstateAgent",
        "name": "{{ addslashes($agent->nom_complet) }}",
        "description": "{{ addslashes($bioText) }}",
        "url": "{{ $canonicalUrl }}",
        "image": "{{ $agentPhoto }}"
        @if($agent->telephone),"telephone": "{{ $agent->telephone }}"@endif
        @if($agent->adresse),"address": {"@type": "PostalAddress", "streetAddress": "{{ addslashes($agent->adresse) }}", "addressCountry": "SN"}@endif
    }
    </script>
@endsection

<style>
    #map {
        height: 500px !important
    }

    td {
        font-size: 12px
    }

    .icon-card {
        border-radius: 50px;
        border: 1px solid #26e3c0;
        padding: 2px;
        background: #26e3c0;
    }

</style>
<style>
    #map { height: 750px}
    td{font-size: 12px}
    .btn-danger{
      background: rgb(203, 33, 33)
    }
  </style>
  <style>
    .price-marker {
      background: #0d1c2e;
      color: white;
      padding: 4px 8px;
      border-radius: 6px;
      font-weight: bold;
      font-size: 12px;
      cursor: pointer;
    }
  
    .custom-popup {
      width: 200px;
    }
  
    .custom-popup img {
      width: 100%;
      border-radius: 8px;
    }
  
    .custom-popup h4 {
      margin: 8px 0 4px;
      font-size: 16px;
    }
  
    .custom-popup p {
      margin: 0;
      font-size: 13px;
      color: #555;
    }
    .mapboxgl-popup-content {
      border-radius: 10px !important;
  }
  </style>
@section('content')
<div class="container">
    <div class="hero-banner"></div>
    <main class="main-content">
        <div class="left-column">
            <div class="profile-card d-flex justify-content-between align-items-center">
                <div class="profile-photo">
                    <img src="{{ asset($agent->user->image?$agent->user->image->url:'/img/agent-default.png') }}" alt="{{ $agent->nom_complet }}">
                </div>
                <div class="profile-details">
                    <div class="profile-info">
                        <div style="width: 100%; text-align:right" class="text-right">
                            <a title="partager le profil" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}&quote={{ urlencode($agent->nom_complet) }}"
                                target="_blank" rel="noopener noreferrer" class="btn btn-xs btn-light" title="partager le profil">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="m21.707 11.293l-8-8A1 1 0 0 0 12 4v3.545A11.015 11.015 0 0 0 2 18.5V20a1 1 0 0 0 1.784.62a11.46 11.46 0 0 1 7.887-4.049c.05-.006.175-.016.329-.026V20a1 1 0 0 0 1.707.707l8-8a1 1 0 0 0 0-1.414M14 17.586V15.5a1 1 0 0 0-1-1c-.255 0-1.296.05-1.562.085a14 14 0 0 0-7.386 2.948A9.013 9.013 0 0 1 13 9.5a1 1 0 0 0 1-1V6.414L19.586 12Z"/></svg>
                            </a>
                        </div>
                        <div class="profile-name-row">
                            <h1 class="profile-name text-capitalize d-flex align-items-center gap-2 flex-wrap">
                                {{ $agent->nom_complet }}
                                @if($agent->disponibilite ?? false)
                                @php
                                  $dispColor = $agent->disponibilite === 'disponible' ? '#2E7D32' : ($agent->disponibilite === 'occupe' ? '#C49A0C' : '#dc3545');
                                  $dispLabel = $agent->disponibilite === 'disponible' ? 'Disponible' : ($agent->disponibilite === 'occupe' ? 'Occupé' : 'En congé');
                                @endphp
                                <span style="font-size:11px;font-weight:600;background:{{ $dispColor }};color:#fff;padding:3px 10px;border-radius:20px;white-space:nowrap;">● {{ $dispLabel }}</span>
                                @endif
                            </h1>
                            @php $noteMoyenne = $agent->noteMoyenne(); $nbAvis = $agent->avis()->count(); @endphp
                            <div class="profile-rating">
                                <span class="rating-score">{{ $noteMoyenne > 0 ? $noteMoyenne : '—' }}</span>
                                <span class="rating-star">
                                    @for($s = 1; $s <= 5; $s++)
                                        <i class="fas fa-star{{ $s <= round($noteMoyenne) ? '' : ($s - 0.5 <= $noteMoyenne ? '-half-alt' : '') }}" style="color:{{ $s <= $noteMoyenne ? '#f59e0b' : '#ccc' }};font-size:12px;"></i>
                                    @endfor
                                    <small style="font-size:11px;color:#888;">({{ $nbAvis }})</small>
                                </span>
                            </div>
                        </div>
                        <div class="profile-properties">{{ $agent->immos->count() > 0?'+ de '.$agent->immos->count() : 0}} propriété(s)</div>
                        <p class="text-sm">{{ Str::limit($agent->bio, 230) }}</p>

                    </div>
                    <img class="agency-logo" src="{{ asset($agent->user->image?$agent->user->image->url:'/img/agence-default.png') }}" alt="Logo agence">
                </div>
            </div>


            <section class="content-section">
                <h2 class="section-title">À propos de <span class="text-capitalize">{{$agent->nom_complet}}</span></h2>
                <p class="text-sm">
                    @if($agent->description!=null)
                    {!!$agent->description!!}
                    @else
                    <p class="text-sm">{{ $agent->bio }}</p>
                    @endif
                </p>
                {{-- <a href="#" class="view-more">Voir Plus</a> --}}
            </section>
            <section class="content-section">
                <h2 class="section-title">Expérience</h2>
                @if($agent->experience_annees ?? false)
                  <p class="text-sm"><strong>{{ $agent->experience_annees }}</strong> an(s) d'expérience</p>
                @else
                  <p class="text-sm">{{$agent->experience!=null?$agent->experience:0}} mois</p>
                @endif
                @if(($agent->certifications ?? false) && count($agent->certifications ?? []))
                  <div class="d-flex flex-wrap gap-1 mt-2">
                    @foreach($agent->certifications as $cert)
                      <span style="font-size:11px;background:#e8f5e9;color:#2E7D32;border:1px solid #2E7D32;border-radius:20px;padding:2px 10px;font-weight:600;">🏅 {{ $cert }}</span>
                    @endforeach
                  </div>
                @endif
            </section>

            {{-- Spécialités --}}
            @if(($agent->specialites ?? false) && count($agent->specialites ?? []))
            <section class="content-section">
                <h2 class="section-title">Spécialités</h2>
                <div class="d-flex flex-wrap gap-2">
                  @foreach($agent->specialites as $spec)
                    <span style="font-size:12px;background:#f1f8e9;color:#2E7D32;border:2px solid #2E7D32;border-radius:20px;padding:4px 14px;font-weight:600;">{{ $spec }}</span>
                  @endforeach
                </div>
            </section>
            @endif

            {{-- Description pro --}}
            @if($agent->description_pro ?? false)
            <section class="content-section">
                <h2 class="section-title">Présentation professionnelle</h2>
                <p class="text-sm">{{ $agent->description_pro }}</p>
            </section>
            @endif



            <section class="content-section">
                <h2 class="section-title">Zones d'opération</h2>
                <div class="zones-grid">

                    <div class="zone-column">
                        @foreach ($agent->mes_zones() as $zone)
                        <span class="text-sm">{{ $zone->name }}</span>
                        @endforeach
    
                    </div>
                </div>
            </section>


            <section class="content-section">
                {{-- <h2 class="section-title">Agence Affiliée</h2>
                <p class="text-sm">{{$agent->agent?$agent->agent->nom_complet:''}}</p> --}}
            </section>
            <div class="accordion mt-0">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-title">Voir listings ({{ count($annonces) }})</div>
                        <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9L12 15L18 9" stroke="#061630" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="d-flex mb-3" style="gap: 10px">
                                <button class="btn btn-sm btn-primary" onclick="filterMarkers('all', this)">Toutes les annonces {{ count($annonces) }}</button>
                                <button class="btn btn-sm btn-light" onclick="filterMarkers(1, this)">Achats {{ count($annonces->where('type_location_id',1)) }}</button>
                                <button class="btn btn-sm btn-light" onclick="filterMarkers(2, this)">Locations {{ count($annonces->whereIn('type_location_id',[2,3])) }}</button>
                            </div>
                              
                            
                        </div>
                        <div class="col-lg-12 col-12">
                            <div id="map"></div>
                          </div>
                        {{-- @if(count($annonces))
                            @foreach ($annonces as $annonce)
                                <a href="{{ route('annonce',$annonce->slug) }}" target="_blank" class="col-lg-2 col-6 m-2 text-center text-capitalize">
                                    <div class="rounded border text-sm p-1">{{ $annonce->name }}</div>
                                </a>
                            @endforeach
                        @endif --}}
                        <!--Contenu-->
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-title">
                            Avis &amp; Évaluations ({{ $agent->avis()->count() }})
                            @if($agent->noteMoyenne() > 0)
                                — <span style="color:#f59e0b;">{{ $agent->noteMoyenne() }}/5</span>
                            @endif
                        </div>
                        <a href="javascript:void(0);" id="toggleCommentaires" class="text-primary d-inline-flex align-items-center" style="font-size: 12px;">
                            <svg id="iconToggle" class="accordion-icon" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" xmlns="http://www.w3.org/2000/svg"
                                 style="transition: transform 0.3s;">
                                <path d="M6 9L12 15L18 9" stroke="#061630" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success py-1 px-2 mt-1" style="font-size:13px;">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger py-1 px-2 mt-1" style="font-size:13px;">{{ session('error') }}</div>
                    @endif

                    @php $avisAgent = $agent->avis()->with('user')->latest()->get(); @endphp

                    @if($avisAgent->count())
                    <div class="row p-2">
                        @foreach($avisAgent as $index => $avi)
                            <div class="col-12 commentaire-item bg-light mb-1 text-sm px-2 py-2 rounded"
                                 style="{{ $index >= 3 ? 'display: none;' : '' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong style="font-size:13px;">{{ $avi->user->name ?? 'Anonyme' }}</strong>
                                    <span style="color:#f59e0b;">
                                        @for($s = 1; $s <= 5; $s++)
                                            <i class="fas fa-star" style="font-size:11px;color:{{ $s <= $avi->note ? '#f59e0b' : '#ccc' }};"></i>
                                        @endfor
                                    </span>
                                </div>
                                @if($avi->commentaire)
                                    <div class="mt-1">{{ $avi->commentaire }}</div>
                                @endif
                                <div class="text-end" style="font-size:10px;color:#888;">{{ $avi->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                    @else
                        <p class="text-sm text-muted px-2 py-1">Aucun avis pour l'instant.</p>
                    @endif

                    @auth
                        @php $monAvis = $agent->avis()->where('user_id', auth()->id())->first(); @endphp
                        <div class="p-2">
                            <p class="text-sm mb-1"><strong>{{ $monAvis ? 'Modifier mon avis' : 'Laisser un avis' }}</strong></p>
                            <form action="{{ route('avis.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="fournisseur_id" value="{{ $agent->id }}">
                                <div class="d-flex mb-2" style="gap:6px;">
                                    @for($s = 1; $s <= 5; $s++)
                                        <label style="cursor:pointer;font-size:22px;color:{{ $monAvis && $monAvis->note >= $s ? '#f59e0b' : '#ccc' }};" title="{{ $s }} étoile{{ $s>1?'s':'' }}">
                                            <input type="radio" name="note" value="{{ $s }}" style="display:none;" {{ $monAvis && $monAvis->note == $s ? 'checked' : '' }}>
                                            &#9733;
                                        </label>
                                    @endfor
                                </div>
                                <div class="form-group mb-2">
                                    <textarea class="form-control" name="commentaire" rows="2" placeholder="Votre commentaire (optionnel)" style="font-size:13px;">{{ $monAvis?->commentaire }}</textarea>
                                </div>
                                <button class="btn btn-sm btn-dark text-white">{{ $monAvis ? 'Mettre à jour' : 'Publier' }}</button>
                            </form>
                        </div>
                    @else
                        <p class="text-sm px-2 py-1"><a href="{{ route('login') }}">Connectez-vous</a> pour laisser un avis.</p>
                    @endauth
                </div>
                <div class="accordion-item d-none">
                    <div class="accordion-header">
                        <div class="accordion-title">Recommandations (7)</div>
                        <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9L12 15L18 9" stroke="#061630" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="accordion-content">
                        <!--Contenu-->
                    </div>
                </div>
            </div>
        </div>



        <div class="right-column">
            <div class="contact-card">
                <h3 class="contact-title">Détails Contacts</h3>

                <div class="contact-list">
                    <div class="contact-item">
                        <svg class="contact-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 5C3 4 4 3 5 3H8C9 3 9.5 4 10 5L11 7C11.5 8 11 9 10 10L9 11C10 13 12 15 14 16L15 15C16 14 17 13.5 18 14L20 15C21 15.5 22 16 22 17V20C22 21 21 22 20 22C10 22 3 15 3 5Z" stroke="#06172B" stroke-width="2" />
                        </svg>
                        <div class="contact-text">{{ $agent->telephone??'' }}</div>
                    </div>
                    <div class="contact-item">
                        <svg class="contact-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#06172B" stroke-width="2" />
                            <path d="M12 2C16 6 16 18 12 22M12 2C8 6 8 18 12 22M2 12H22" stroke="#06172B" stroke-width="2" />
                        </svg>
                        <div class="contact-text">{{ $agent->site??'' }}</div>
                    </div>
                    <div class="contact-item">
                        <svg class="contact-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#06172B" stroke-width="2" />
                            <path d="M20 10C20 16 12 22 12 22C12 22 4 16 4 10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10Z" stroke="#06172B" stroke-width="2" />
                        </svg>
                        <div class="contact-text text-capitalize">{{ $agent->adresse??'' }}</div>
                    </div>
                </div>
                {{-- <div class="contact-agency">
                    <img class="contact-agency-logo" src="{{ asset($agent->user->image?$agent->user->image->url:'/img/agence-default.png') }}" alt="Logo agence">
                </div> --}}
                <div class="contact-actions">
                    <div class="contact-action">
                        <svg class="action-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 14L14 10M14 10H7M14 10V17" stroke="#06172B" stroke-width="2" stroke-linecap="round" />
                            <path d="M12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3Z" stroke="#06172B" stroke-width="2" />
                        </svg>
                        <div class="action-text">Agence Affiliée : {{ $agent->agent?$agent->agent->nom_complet:'' }}</div>
                    </div>
                    <div class="contact-action">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m21.707 11.293l-8-8A1 1 0 0 0 12 4v3.545A11.015 11.015 0 0 0 2 18.5V20a1 1 0 0 0 1.784.62a11.46 11.46 0 0 1 7.887-4.049c.05-.006.175-.016.329-.026V20a1 1 0 0 0 1.707.707l8-8a1 1 0 0 0 0-1.414M14 17.586V15.5a1 1 0 0 0-1-1c-.255 0-1.296.05-1.562.085a14 14 0 0 0-7.386 2.948A9.013 9.013 0 0 1 13 9.5a1 1 0 0 0 1-1V6.414L19.586 12Z"/></svg>
                        <div class="action-text">
                            <a title="partager le profil" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}&quote={{ urlencode($agent->nom_complet) }}"
                                target="_blank" rel="noopener noreferrer" title="partager le profil">
                                Partager le profil

                            </a>
                        </div>
                    </div>

                    <div class="contact-action">
                        <svg class="action-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 7V5C4 4.44772 4.44772 4 5 4H19C19.5523 4 20 4.44772 20 5V19C20 19.5523 19.5523 20 19 20H5C4.44772 20 4 19.5523 4 19V17" stroke="#06172B" stroke-width="2" stroke-linecap="round" />
                            <path d="M16 12H8M12 8V16" stroke="#06172B" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <div class="action-text">Prendre RDV</div>
                    </div>
                </div>

                {{-- Réseaux sociaux --}}
                @php $rs = $agent->reseaux_sociaux ?? []; @endphp
                @if(!empty($rs['facebook']) || !empty($rs['linkedin']) || !empty($rs['instagram']))
                <div class="mt-3" style="border-top:1px solid #f0f0f0;padding-top:12px;">
                  <div style="font-size:12px;font-weight:600;color:#888;margin-bottom:8px;">Réseaux sociaux</div>
                  <div class="d-flex gap-2">
                    @if(!empty($rs['facebook']))
                    <a href="{{ $rs['facebook'] }}" target="_blank" rel="noopener" style="background:#1877f2;color:#fff;border-radius:6px;padding:4px 10px;font-size:11px;font-weight:700;text-decoration:none;">f Facebook</a>
                    @endif
                    @if(!empty($rs['linkedin']))
                    <a href="{{ $rs['linkedin'] }}" target="_blank" rel="noopener" style="background:#0a66c2;color:#fff;border-radius:6px;padding:4px 10px;font-size:11px;font-weight:700;text-decoration:none;">in LinkedIn</a>
                    @endif
                    @if(!empty($rs['instagram']))
                    <a href="{{ $rs['instagram'] }}" target="_blank" rel="noopener" style="background:#e1306c;color:#fff;border-radius:6px;padding:4px 10px;font-size:11px;font-weight:700;text-decoration:none;">📷 Instagram</a>
                    @endif
                  </div>
                </div>
                @endif

                {{-- Créneaux de disponibilité --}}
                @php
                  try {
                    $creneauxPub = $agent->disponibilites()
                      ->where('date', '>=', now()->toDateString())
                      ->where('statut', 'disponible')
                      ->orderBy('date')->orderBy('heure_debut')
                      ->limit(10)->get();
                  } catch(\Exception $e) { $creneauxPub = collect(); }
                @endphp
                @if($creneauxPub->isNotEmpty())
                <div class="mt-3" style="border-top:1px solid #f0f0f0;padding-top:12px;">
                  <div style="font-size:12px;font-weight:700;color:#0d1c2e;margin-bottom:10px;">📅 Créneaux disponibles</div>
                  @foreach($creneauxPub as $c)
                  <div style="background:#f1f8e9;border-radius:8px;padding:8px 12px;margin-bottom:6px;font-size:12px;">
                    <div class="d-flex align-items-center justify-content-between">
                      <div>
                        <span style="font-weight:700;color:#2E7D32;">{{ $c->date->format('d/m/Y') }}</span>
                        <span style="color:#666;margin-left:8px;">{{ substr($c->heure_debut,0,5) }} – {{ substr($c->heure_fin,0,5) }}</span>
                        <span style="background:#e8f5e9;color:#2E7D32;border-radius:10px;padding:1px 8px;font-size:10px;margin-left:6px;">{{ ucfirst($c->type_rdv) }}</span>
                      </div>
                      @auth
                      <form method="POST" action="{{ route('disponibilite.reserver', $c->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:#2E7D32;color:#fff;border:none;border-radius:6px;padding:3px 10px;font-size:10px;cursor:pointer;"
                          onclick="return confirm('Réserver ce créneau ?')">Réserver</button>
                      </form>
                      @else
                      <a href="{{ route('login') }}" style="background:#2E7D32;color:#fff;border-radius:6px;padding:3px 10px;font-size:10px;text-decoration:none;">Réserver</a>
                      @endauth
                    </div>
                  </div>
                  @endforeach
                </div>
                @endif
            </div>
        </div>
    </main>
</div 
@endsection

@section('scriptBottom')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle avis
            const toggleBtn = document.getElementById('toggleCommentaires');
            const icon = document.getElementById('iconToggle');
            let expanded = false;
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                    const items = document.querySelectorAll('.commentaire-item');
                    items.forEach((item, index) => {
                        if (index >= 3) item.style.display = expanded ? 'none' : 'block';
                    });
                    icon.style.transform = expanded ? 'rotate(0deg)' : 'rotate(180deg)';
                    expanded = !expanded;
                });
            }

            // Interactive star rating
            const starLabels = document.querySelectorAll('label[title]');
            starLabels.forEach((label, idx) => {
                label.addEventListener('mouseenter', () => {
                    starLabels.forEach((l, i) => l.style.color = i <= idx ? '#f59e0b' : '#ccc');
                });
                label.addEventListener('click', () => {
                    label.querySelector('input').checked = true;
                    starLabels.forEach((l, i) => l.style.color = i <= idx ? '#f59e0b' : '#ccc');
                });
            });
            const starContainer = document.querySelector('.d-flex.mb-2');
            if (starContainer) {
                starContainer.addEventListener('mouseleave', () => {
                    const checked = starContainer.querySelector('input:checked');
                    const checkedIdx = checked ? parseInt(checked.value) - 1 : -1;
                    starLabels.forEach((l, i) => l.style.color = i <= checkedIdx ? '#f59e0b' : '#ccc');
                });
            }
        });
    </script>
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.0/mapbox-gl.js"></script>
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.0/mapbox-gl.css" rel="stylesheet">
  <script>
    const select = document.getElementById('mySelect');
    const type = document.getElementById('type');
    const price = document.getElementById('price');

    select.addEventListener('change', function () {
      // Ajoute la classe "highlight"
      this.classList.add('highlight');

      // Retire la surbrillance après 1 seconde
      // setTimeout(() => {
      //   this.classList.remove('highlight');
      // }, 1000);
    });
    type.addEventListener('change', function () {
      // Ajoute la classe "highlight"
      this.classList.add('highlight');
    });
    price.addEventListener('change', function () {
      // Ajoute la classe "highlight"
      this.classList.add('highlight');
    });

  </script>
  <script>
    mapboxgl.accessToken = '{{ config("services.mapbox.token") }}';
  
    const map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [-17.4467, 14.6928],
      zoom: 12,
      attributionControl: false
    });
  
    const datas = @json($annonces);
    const markers = [];
  
    function kConverter(num) {
      return num <= 999 ? num : (0.1 * Math.floor(num / 100)).toFixed(1).replace('.0','') + 'k';
    }
  
    function asset(path) {
      return `${window.location.origin}/${path.replace(/^\/+/, '')}`;
    }
  
    function getAdresseComplete(annonce) {
      if (annonce.commune) {
        const adresse = annonce.adresse ?? '---';
        const commune = annonce.commune.name ?? '';
        const departement = annonce.commune.departement?.name ?? '';
        return `${adresse}, ${commune}, ${departement}`;
      } else {
        return annonce.adresse ?? '---';
      }
    }
  
    function createMarker(element) {
      const viewUrl = `/annonces/${element.slug}`;

      if (!element?.lon || !element?.lat) return;
  
      const loc = {
        coords: [parseFloat(element.lon), parseFloat(element.lat)],
        price: kConverter(element.prix),
        image: element.images?.[0]?.url || '',
        city: element.adresse ?? '',
        priceText: (element.prix ?? 0) + ' CFA',
        type: element.immo?.name ?? '',
        chambre: element?.pieces?.[1]?.Chambres ?? 0,
        cuisine: element?.pieces?.[4]?.Cuisines ?? 0,
        salon: element?.pieces?.[2]?.Salons ?? 0,
        toilette: element?.pieces?.[3]?.Toilettes ?? 0,
      };
  
      const el = document.createElement('div');
      el.className = 'price-marker';
      el.textContent = loc.price;
  
      const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(`
            <div class="custom-popup">
            <img src="${asset(loc.image)}" alt="photo">
            <h4>${loc.priceText}</h4>
            <p><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4s-4 1.794-4 4s1.794 4 4 4m0-6c1.103 0 2 .897 2 2s-.897 2-2 2s-2-.897-2-2s.897-2 2-2"/><path fill="currentColor" d="M11.42 21.814a1 1 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819M12 4c3.309 0 6 2.691 6 6.005c.021 4.438-4.388 8.423-6 9.73c-1.611-1.308-6.021-5.294-6-9.735c0-3.309 2.691-6 6-6"/></svg> ${loc.city} <br>  ${loc.type}</p>
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 48 48"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"><path d="M9 25a5 5 0 1 0 10 0a5 5 0 1 0-10 0m10.23-6.487c.136-1.366 1.26-2.387 2.631-2.443c5.229-.216 10.06.098 13.939.545c5.456.628 9.2 5.405 9.2 10.897V28a2 2 0 0 1-2 2H21.204c-.969 0-1.793-.694-1.904-1.655A47 47 0 0 1 19 23.1c0-1.795.11-3.387.23-4.587"/><path d="M6.979 11.033c1.125.082 1.786 1.003 1.835 2.13C8.899 15.118 9 19.103 9 27q0 1.7-.006 3.166C11.363 30.086 15.813 30 24 30h18.982c1.108 0 2.005.902 1.997 2.01c-.032 4.672-.106 7.338-.17 8.826c-.05 1.127-.71 2.049-1.835 2.13a14 14 0 0 1-1.958.001c-1.125-.082-1.786-1.004-1.835-2.131c-.045-1.022-.093-2.6-.13-5.003c-2.357.08-6.812.167-15.051.167c-8.245 0-12.7-.087-15.056-.167a183 183 0 0 1-.13 5.004c-.049 1.127-.71 2.048-1.835 2.13Q6.556 42.999 6 43c-.556.001-.696-.013-.979-.033c-1.125-.082-1.786-1.003-1.835-2.13C3.101 38.882 3 34.897 3 27s.101-11.882.186-13.837c.049-1.127.71-2.048 1.835-2.13Q5.444 11.002 6 11c.556-.002.696.012.979.033"/></g></svg>
              ${loc.chambre}
            </span>

            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 12.749h4.5a1.5 1.5 0 0 0 1.5-1.5v-9a1.5 1.5 0 0 0-1.5-1.5h-3a1.5 1.5 0 0 0-1.5 1.5zm-12-3a1.5 1.5 0 1 0 0 3h12v-3zM19.7 15.6a3 3 0 0 0 2.047-2.845H5.25a8.25 8.25 0 0 0 4.5 7.35L9 23.25h9.75v-6.22a1.49 1.49 0 0 1 .95-1.431M4.192 7.436a3.48 3.48 0 0 1 3.245-3.25M.75 6.893A6.954 6.954 0 0 1 6.892.751"/></svg>
              ${loc.toilette}
            </span>
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32"><path fill="currentColor" d="M28 13a2 2 0 0 1 2 2v6.064a.936.936 0 0 1-.936.936H28v1a2 2 0 0 1-4 0v-1H8v1a2 2 0 0 1-4 0v-1H2.936A.936.936 0 0 1 2 21.064V15a2 2 0 0 1 4 0v2h20v-2a2 2 0 0 1 2-2M8 15a4 4 0 0 0-4-4V9a2 2 0 0 1 2-2h20a2 2 0 0 1 2 2v2a4 4 0 0 0-4 4z"/></svg>
              ${loc.salon}
            </span>
                      <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16.88" height="15" viewBox="0 0 576 512"><path fill="currentColor" d="M240 144a96 96 0 1 0-192 0a96 96 0 1 0 192 0m44.4 32c-14.5 64.1-71.9 112-140.4 112C64.5 288 0 223.5 0 144S64.5 0 144 0c68.5 0 125.9 47.9 140.4 112h71.8c8.8-9.8 21.6-16 35.8-16h104c26.5 0 48 21.5 48 48s-21.5 48-48 48H392c-14.2 0-27-6.2-35.8-16zM144 80a64 64 0 1 1 0 128a64 64 0 1 1 0-128m256 160c13.3 0 24 10.7 24 24v8h96c13.3 0 24 10.7 24 24s-10.7 24-24 24H280c-13.3 0-24-10.7-24-24s10.7-24 24-24h96v-8c0-13.3 10.7-24 24-24M288 464V352h224v112c0 26.5-21.5 48-48 48H336c-26.5 0-48-21.5-48-48M48 320h128c26.5 0 48 21.5 48 48s-21.5 48-48 48h-16c0 17.7-14.3 32-32 32H64c-17.7 0-32-14.3-32-32v-80c0-8.8 7.2-16 16-16m128 64c8.8 0 16-7.2 16-16s-7.2-16-16-16h-16v32zM24 464h176c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24s10.7-24 24-24"/></svg>
              ${loc.cuisine}
            </span>
            <p>
              <a class="btn btn-xs btn-primary text-sm mt-2" href="/annonces/${element.slug}" target="_blank">Voir l'annonce</a>
              
              </p>
          </div>`);
  
      const marker = new mapboxgl.Marker(el)
        .setLngLat(loc.coords)
        .setPopup(popup)
        .addTo(map);
  
      markers.push(marker);
    }
  
    function clearMarkers() {
      markers.forEach(m => m.remove());
      markers.length = 0;
    }
  
    function renderMarkers(data) {
      clearMarkers();
      data.forEach(el => createMarker(el));
    }
  
    function filterMarkers(typeId, btn) {
      // Update active button style
      document.querySelectorAll('.btn-sm').forEach(b => {
        b.classList.remove('btn-primary');
        b.classList.add('btn-light');
      });
      btn.classList.add('btn-primary');
      btn.classList.remove('btn-light');
  
      const filtered = typeId === 'all' ? datas : datas.filter(el => el.type_location_id == typeId);
      renderMarkers(filtered);
    }
  
    // Initial render
    renderMarkers(datas);
  
    // Attach listeners to buttons (assume you gave IDs)
    document.getElementById('btn-all').addEventListener('click', e => filterMarkers('all', e.target));
    document.getElementById('btn-location').addEventListener('click', e => filterMarkers(1, e.target));
    document.getElementById('btn-achat').addEventListener('click', e => filterMarkers(2, e.target));
  </script>

  <script>
    let timeout = null;

    async function handleInput() {
      clearTimeout(timeout);
      const input = document.getElementById('address').value;

      if (!input) {
        document.getElementById('suggestions').innerHTML = '';
        return;
      }

      timeout = setTimeout(async () => {
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(input)}.json?access_token=${mapboxgl.accessToken}&country=SN&types=place,locality,address`;

        try {
          const res = await fetch(url);
          
          const data = await res.json();
          console.log(data);
          const list = document.getElementById('suggestions');
          list.innerHTML = '';

          data.features.forEach(feature => {
            const li = document.createElement('li');
            li.textContent = feature.place_name;
            li.onclick = () => selectAddress(feature);
            list.appendChild(li);
          });
        } catch (err) {
          console.error("Erreur lors de la récupération des suggestions", err);
        }
      }, 500); // délai anti spam
    }

    function selectAddress(feature) {
      const [lng, lat] = feature.center;
      const context = feature.context;
      let commune = "Non trouvée";
      let region = "Non trouvée";

      context.forEach(item => {
        if (item.id.includes("place")) {
          commune = item.text;
        }
        if (item.id.includes("region")) {
          region = item.text;
        }
      });

      document.getElementById('address').value = feature.place_name;
      document.getElementById('suggestions').innerHTML = '';
      // document.getElementById('commune').textContent = commune;
      // document.getElementById('departement').textContent = region;
      document.getElementById('lon').value = lng;
      document.getElementById('lat').value = lat;

      map.flyTo({ center: [lng, lat], zoom: 13 });
      marker.setLngLat([lng, lat]).addTo(map);
    }
  </script>
@endsection