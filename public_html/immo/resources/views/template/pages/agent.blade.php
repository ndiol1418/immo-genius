@extends('layouts.accueil')
<link href="{{ asset("assets/css/agent.css") }}" rel="stylesheet">

@php
    // Photo
    $agentPhoto = $agent->picture;

    // Téléphone
    $telRaw    = preg_replace('/[^0-9]/', '', $agent->telephone ?? '');
    $telValide = strlen($telRaw) >= 8;
    $telAffiche = $telValide ? $agent->telephone : null;
    $telWA      = $telValide ? (str_starts_with($telRaw, '221') ? $telRaw : '221'.$telRaw) : null;

    // Email
    $emailAgent = $agent->user?->email ?? null;

    // Expérience
    $expMois = (int)($agent->experience ?? 0);
    $expAns  = (int)($agent->experience_annees ?? 0);
    if ($expAns >= 1)        $expLabel = $expAns . ' an' . ($expAns > 1 ? 's' : '') . " d'expérience";
    elseif ($expMois >= 12)  $expLabel = floor($expMois/12) . ' an' . (floor($expMois/12) > 1 ? 's' : '') . " d'expérience";
    elseif ($expMois > 0)    $expLabel = $expMois . " mois d'expérience";
    else                     $expLabel = 'Nouveau sur la plateforme';

    // Spécialités
    $specialites = $agent->specialites ?? [];
    if (empty($specialites)) $specialites = ['Vente', 'Location'];

    // Note
    $noteMoyenne = method_exists($agent, 'noteMoyenne') ? $agent->noteMoyenne() : 0;
    $nbAvis      = $agent->avis()->count();

    // Disponibilité
    $dispColor = match($agent->disponibilite ?? '') {
        'disponible' => '#2E7D32', 'occupe' => '#C49A0C', 'conge' => '#dc3545', default => '#888'
    };
    $dispLabel = match($agent->disponibilite ?? '') {
        'disponible' => 'Disponible', 'occupe' => 'Occupé', 'conge' => 'En congé', default => null
    };
@endphp

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

    {{-- BANNIÈRE AGENT --}}
    <div style="
        width: 100%;
        height: 260px;
        margin: 110px auto 30px;
        border-radius: 18px;
        overflow: hidden;
        position: relative;
        background: linear-gradient(135deg, #0d3b1f 0%, #1B5E20 40%, #2E7D32 70%, #43A047 100%);
        display: flex;
        align-items: flex-end;
        padding: 28px 36px;
        box-shadow: 0 4px 24px rgba(0,0,0,.15);
    ">
        {{-- Formes décoratives --}}
        <div style="position:absolute;top:-40px;right:-40px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,.06);"></div>
        <div style="position:absolute;top:30px;right:140px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.04);"></div>
        <div style="position:absolute;bottom:-30px;left:30%;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.05);"></div>

        {{-- Contenu texte --}}
        <div style="position:relative;z-index:2;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:6px;">
                <h1 style="color:#fff;font-size:clamp(20px,3vw,32px);font-weight:800;margin:0;text-shadow:0 2px 8px rgba(0,0,0,.3);">
                    {{ $agent->nom_complet }}
                </h1>
                @if($dispLabel)
                <span style="background:{{ $dispColor }};color:#fff;font-size:11px;padding:3px 12px;border-radius:20px;font-weight:600;white-space:nowrap;">
                    ● {{ $dispLabel }}
                </span>
                @endif
            </div>
            <p style="color:rgba(255,255,255,.8);font-size:14px;margin:0;">
                🏡 Agent immobilier · {{ $agent->name ?? config('app.name') }}
            </p>
        </div>

        {{-- Logo plateforme --}}
        <div style="position:absolute;top:20px;right:28px;z-index:2;">
            <span style="color:rgba(255,255,255,.4);font-size:11px;letter-spacing:1px;text-transform:uppercase;">
                {{ config('app.name') }}
            </span>
        </div>
    </div>

    <main class="main-content">
        <div class="left-column">
            <div class="profile-card d-flex justify-content-between align-items-center">
                <div class="profile-photo">
                    <img src="{{ asset($agentPhoto) }}" alt="{{ $agent->nom_complet }}">
                    {{-- 3 boutons d'action --}}
                    <div class="d-flex gap-2 mt-2 flex-wrap justify-content-center">
                        @if($telValide)
                        <a href="tel:{{ $telAffiche }}" class="btn btn-sm btn-success">📞 Appeler</a>
                        @endif
                        <button class="btn btn-sm" style="background:#25D366;color:#fff;" data-bs-toggle="modal" data-bs-target="#modalMessage">💬 Message</button>
                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#modalRDV">📅 RDV</button>
                    </div>
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
                            <h1 class="profile-name text-capitalize">{{ $agent->nom_complet }}</h1>
                            <div class="profile-rating">
                                <span class="rating-score">4.9</span>
                                <span class="rating-star"> <i class="fas fa-star-half-alt"></i>
                                </span>
                            </div>
                        </div>
                        <div class="profile-properties">{{ $agent->immos->count() > 0?'+ de '.$agent->immos->count() : 0}} propriété(s)</div>
                        <p class="text-sm">{{ Str::limit($agent->bio, 230) }}</p>

                    </div>
                    <img class="agency-logo" src="{{ asset($agentPhoto) }}" alt="Logo agence">
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
                <p class="text-sm">{{ $expLabel }}</p>
            </section>

            <section class="content-section">
                <h2 class="section-title">Spécialités</h2>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($specialites as $spe)
                        <span class="badge" style="background:#2E7D32;color:#fff;font-size:12px;padding:5px 10px;border-radius:20px;">{{ $spe }}</span>
                    @endforeach
                </div>
            </section>

            <section class="content-section">
                <h2 class="section-title">Statistiques</h2>
                <div class="d-flex flex-wrap gap-3">
                    <div class="text-center p-2 rounded border" style="min-width:80px;">
                        <div style="font-size:20px;font-weight:700;color:#2E7D32;">{{ $agent->immos->count() }}</div>
                        <div style="font-size:11px;color:#666;">Annonces</div>
                    </div>
                    <div class="text-center p-2 rounded border" style="min-width:80px;">
                        <div style="font-size:20px;font-weight:700;color:#2E7D32;">{{ $nbAvis }}</div>
                        <div style="font-size:11px;color:#666;">Avis</div>
                    </div>
                    <div class="text-center p-2 rounded border" style="min-width:80px;">
                        <div style="font-size:20px;font-weight:700;color:#f5a623;">
                            @for($i=1;$i<=5;$i++)
                                <span style="color:{{ $i <= round($noteMoyenne) ? '#f5a623' : '#ccc' }};">★</span>
                            @endfor
                        </div>
                        <div style="font-size:11px;color:#666;">{{ number_format($noteMoyenne,1) }}/5</div>
                    </div>
                </div>
            </section>



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
                        <div class="accordion-title">Evaluations et Commentaires ({{ count($agent->commentaires) }})</div>
                        <a href="javascript:void(0);" id="toggleCommentaires" class="text-primary d-inline-flex align-items-center" style="font-size: 12px;">
                            <span class="me-1"></span>
                            <svg id="iconToggle" class="accordion-icon" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" xmlns="http://www.w3.org/2000/svg"
                                 style="transition: transform 0.3s;">
                                <path d="M6 9L12 15L18 9" stroke="#061630" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </a>
                    </div>
                        <!--Contenu-->
                        @if (count($agent->commentaires))
                        <div class="row p-2">
                            @foreach ($agent->commentaires as $index => $commentaire)
                                <div class="col-12 commentaire-item bg-light mb-1 text-sm px-2 py-1 rounded"
                                     style="{{ $index >= 3 ? 'display: none;' : '' }}">
                                    {{ $commentaire->description }}
                                    <div class="text-end" style="font-size: 10px;">
                                        {{ $commentaire->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @endforeach
                    
                        </div>
                    @endif
                    
                        <form action="{{ route('commentaires.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea  class="form-control" id="" name="description" required cols="30"></textarea>
                                <input type="hidden" name="fournisseur_id" value="{{ $agent->id }}">
                            </div>
                            <button class="btn btn-sm btn-dark text-white mt-2">Valider</button>
                        </form>
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
                    {{-- Téléphone --}}
                    <div class="contact-item">
                        <svg class="contact-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 5C3 4 4 3 5 3H8C9 3 9.5 4 10 5L11 7C11.5 8 11 9 10 10L9 11C10 13 12 15 14 16L15 15C16 14 17 13.5 18 14L20 15C21 15.5 22 16 22 17V20C22 21 21 22 20 22C10 22 3 15 3 5Z" stroke="#06172B" stroke-width="2" />
                        </svg>
                        <div class="contact-text">
                            @if($telValide)
                                <a href="tel:{{ $telAffiche }}" style="color:#2E7D32;font-weight:600;">📞 {{ $telAffiche }}</a>
                            @else
                                <span class="text-muted">Non renseigné</span>
                            @endif
                        </div>
                    </div>
                    {{-- Email --}}
                    @if($emailAgent)
                    <div class="contact-item">
                        <svg class="contact-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="4" width="20" height="16" rx="2" stroke="#06172B" stroke-width="2"/>
                            <path d="M2 7L12 13L22 7" stroke="#06172B" stroke-width="2"/>
                        </svg>
                        <div class="contact-text"><a href="mailto:{{ $emailAgent }}" style="color:#2E7D32;">{{ $emailAgent }}</a></div>
                    </div>
                    @endif
                    {{-- Site web --}}
                    @if($agent->site)
                    <div class="contact-item">
                        <svg class="contact-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#06172B" stroke-width="2" />
                            <path d="M12 2C16 6 16 18 12 22M12 2C8 6 8 18 12 22M2 12H22" stroke="#06172B" stroke-width="2" />
                        </svg>
                        <div class="contact-text">🌐 <a href="{{ $agent->site }}" target="_blank" rel="noopener" style="color:#2E7D32;">{{ $agent->site }}</a></div>
                    </div>
                    @endif
                    {{-- Adresse --}}
                    @if($agent->adresse)
                    <div class="contact-item">
                        <svg class="contact-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#06172B" stroke-width="2" />
                            <path d="M20 10C20 16 12 22 12 22C12 22 4 16 4 10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10Z" stroke="#06172B" stroke-width="2" />
                        </svg>
                        <div class="contact-text text-capitalize">📍 {{ $agent->adresse }}</div>
                    </div>
                    @endif
                    {{-- Agence affiliée --}}
                    @if($agent->agent)
                    <div class="contact-item">
                        <svg class="contact-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 14L14 10M14 10H7M14 10V17" stroke="#06172B" stroke-width="2" stroke-linecap="round" />
                            <path d="M12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3Z" stroke="#06172B" stroke-width="2" />
                        </svg>
                        <div class="contact-text">🏢 {{ $agent->agent->nom_complet }}</div>
                    </div>
                    @endif
                </div>

                {{-- Boutons d'action --}}
                <div class="d-flex flex-column gap-2 mt-3">
                    @if($telValide)
                    <a href="tel:{{ $telAffiche }}" class="btn btn-success w-100">📞 Appeler</a>
                    <a href="https://wa.me/{{ $telWA }}" target="_blank" class="btn w-100" style="background:#25D366;color:#fff;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="me-1"><path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
                        WhatsApp
                    </a>
                    @endif
                    <button class="btn w-100" style="background:#0d6efd;color:#fff;" data-bs-toggle="modal" data-bs-target="#modalMessage">💬 Envoyer un message</button>
                    <button class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#modalRDV">📅 Prendre RDV</button>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}&quote={{ urlencode($agent->nom_complet) }}" target="_blank" rel="noopener" class="btn btn-light w-100">🔗 Partager le profil</a>
                </div>
            </div>
        </div>
    </main>
</div>

{{-- ===================== MODAL RDV ===================== --}}
<div class="modal fade" id="modalRDV" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:#2E7D32;color:#fff;">
        <h5 class="modal-title">📅 Prendre rendez-vous avec {{ $agent->prenom ?? $agent->nom_complet }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('rdv.store') }}" method="POST">
        @csrf
        <input type="hidden" name="agent_id" value="{{ $agent->id }}">
        <div class="modal-body">
          @if(session('rdv_success'))
            <div class="alert alert-success">{{ session('rdv_success') }}</div>
          @endif
          <div class="mb-3">
            <label class="form-label fw-semibold">Votre nom complet *</label>
            <input type="text" name="nom_client" class="form-control" required placeholder="Ex : Amadou Diallo" value="{{ auth()->user()?->name ?? '' }}">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Votre téléphone *</label>
            <input type="text" name="tel_client" class="form-control" required placeholder="Ex : 77 123 45 67" value="{{ auth()->user()?->telephone ?? '' }}">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Votre email</label>
            <input type="email" name="email_client" class="form-control" placeholder="email@exemple.com" value="{{ auth()->user()?->email ?? '' }}">
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label fw-semibold">Date *</label>
              <input type="date" name="date" class="form-control" required min="{{ date('Y-m-d') }}">
            </div>
            <div class="col-6 mb-3">
              <label class="form-label fw-semibold">Heure *</label>
              <select name="heure" class="form-select" required>
                @for($h = 8; $h <= 18; $h++)
                  <option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02dh00', $h) }}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Type de rendez-vous *</label>
            <div class="d-flex gap-3">
              <label><input type="radio" name="type_rdv" value="visite" required> Visite bien</label>
              <label><input type="radio" name="type_rdv" value="consultation"> Consultation</label>
              <label><input type="radio" name="type_rdv" value="autre"> Autre</label>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Message (optionnel)</label>
            <textarea name="message" class="form-control" rows="3" placeholder="Précisez votre demande..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-success">✅ Confirmer le RDV</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ===================== MODAL MESSAGE ===================== --}}
<div class="modal fade" id="modalMessage" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:#0d6efd;color:#fff;">
        <h5 class="modal-title">💬 Contacter {{ $agent->prenom ?? $agent->nom_complet }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      @auth
      <form action="{{ route('agent.message', $agent->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Votre message *</label>
            <textarea name="contenu" class="form-control" rows="5" required placeholder="Bonjour, je suis intéressé(e) par..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">📨 Envoyer</button>
        </div>
      </form>
      @else
      <div class="modal-body text-center py-4">
        <p>Vous devez être connecté pour envoyer un message.</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
      </div>
      @endauth
    </div>
  </div>
</div>

@endsection

@section('scriptBottom')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggleCommentaires');
            const icon = document.getElementById('iconToggle');
            let expanded = false;

            toggleBtn.addEventListener('click', function () {
                const items = document.querySelectorAll('.commentaire-item');

                items.forEach((item, index) => {
                    if (index >= 5) {
                        item.style.display = expanded ? 'none' : 'block';
                    }
                });

                toggleBtn.querySelector('span').textContent = expanded ? '' : '';
                icon.style.transform = expanded ? 'rotate(0deg)' : 'rotate(180deg)';
                expanded = !expanded;
            });
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
    mapboxgl.accessToken = 'pk.eyJ1Ijoidnl0aW1vIiwiYSI6ImNtOThpNnNpNDAyZnYyanNlbmR1dDFpMjcifQ.Z3zUfwJ59hZX2t6V5cE8Tw';
  
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