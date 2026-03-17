@extends('layouts.accueil')
<style>
    #map { height: 500px }
    td { font-size: 12px }
    .agent-filter-bar { background:#f8f9fa;border-radius:12px;padding:16px 20px;margin-bottom:24px;border:1px solid #e8e8e8; }
    .agent-filter-bar input, .agent-filter-bar select { border-radius:8px;font-size:13px; }
    .card-premium { border:2px solid #f5a623 !important;background:linear-gradient(135deg,#fffde7 0%,#fff 100%); }
    .badge-premium { background:#f5a623;color:#fff;font-size:10px;padding:2px 8px;border-radius:20px;font-weight:700; }
</style>

@section('content')
    {{-- Hero --}}
    <section style="
        position: relative;
        margin: 100px 5% 0;
        border-radius: 16px;
        overflow: hidden;
        height: 420px;
    ">
        {{-- Image de fond --}}
        <img src="{{ asset('img/agents.png') }}" alt="Agents immobiliers"
             style="
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center 15%;
             ">

        {{-- Overlay dégradé pour lisibilité --}}
        <div style="
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.25) 50%, rgba(0,0,0,0.10) 100%);
        "></div>

        {{-- Texte centré --}}
        <div style="
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
        ">
            <h2 style="color:#fff;font-size:clamp(22px,4vw,40px);font-weight:800;text-shadow:0 2px 8px rgba(0,0,0,.5);margin-bottom:10px;text-transform:uppercase;letter-spacing:1px;">
                Un bon agent fait<br>toute la différence.
            </h2>
            <p style="color:rgba(255,255,255,.9);font-size:clamp(13px,2vw,18px);text-shadow:0 1px 4px rgba(0,0,0,.5);margin:0;">
                Plateforme d'annonces immobilières pour tous
            </p>
        </div>
    </section>

    {{-- Recherche --}}
    <div class="container mt-4" style="max-width:900px;">
        @include('template.search-agent')
    </div>

    @include('template.components.c_section_agents')

    {{-- ===== FILTRE / RECHERCHE RAPIDE ===== --}}
    <div class="container mt-4">
        <div class="agent-filter-bar">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-md-5">
                    <input type="text" id="filterNom" class="form-control" placeholder="🔍 Rechercher par nom…" oninput="filterAgents()">
                </div>
                <div class="col-12 col-md-4">
                    <select id="filterZone" class="form-select" onchange="filterAgents()">
                        <option value="">📍 Toutes les zones</option>
                        <option>Dakar</option>
                        <option>Almadies</option>
                        <option>Mermoz</option>
                        <option>Plateau</option>
                        <option>Pikine</option>
                        <option>Thiès</option>
                        <option>Saint-Louis</option>
                        <option>Ziguinchor</option>
                        <option>Diamniadio</option>
                        <option>Mbour</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <select id="filterDispo" class="form-select" onchange="filterAgents()">
                        <option value="">🟢 Toutes disponibilités</option>
                        <option value="disponible">Disponible</option>
                        <option value="occupe">Occupé</option>
                        <option value="conge">En congé</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== AGENTS PREMIUM ===== --}}
    <section class="services section" id="section-premium">
        <div class="container">
            <div class="d-flex align-items-center gap-2 mb-3">
                <h3 class="mb-0">Agents Premium</h3>
                <span class="badge-premium">⭐ Vérifiés</span>
            </div>
            <div class="row g-3" id="list-premium">
                @foreach ($agents->where('is_premium', 1) as $agent)
                @php
                    $noteAgent  = $agent->noteMoyenne();
                    $agentPhoto = $agent->picture;
                    $spes       = $agent->specialites ?? [];
                    $spesArr    = is_string($spes) ? json_decode($spes, true) : (array)$spes;
                    $spe1       = $spesArr[0] ?? null;
                    $zonesRaw   = $agent->zones ?? [];
                    $zonesArr   = is_string($zonesRaw) ? json_decode($zonesRaw, true) : (array)$zonesRaw;
                    $zones      = implode(', ', $zonesArr ?? []);
                    $dispColor  = match($agent->disponibilite ?? '') { 'disponible'=>'#2E7D32','occupe'=>'#C49A0C','conge'=>'#dc3545',default=>'#aaa' };
                    $dispLabel  = match($agent->disponibilite ?? '') { 'disponible'=>'Disponible','occupe'=>'Occupé','conge'=>'En congé',default=>null };
                @endphp
                <div class="col-12 col-lg-6 agent-card-wrap"
                     data-nom="{{ strtolower($agent->nom_complet) }}"
                     data-zone="{{ strtolower($zones) }}"
                     data-dispo="{{ $agent->disponibilite ?? '' }}">
                    <div class="card card-premium h-100" style="border-radius:14px;">
                        <div class="card-body d-flex gap-3 align-items-start p-3">
                            {{-- Photo --}}
                            <div class="position-relative flex-shrink-0">
                                <img src="{{ asset($agentPhoto) }}"
                                     alt="{{ $agent->nom_complet }}"
                                     style="width:90px;height:90px;border-radius:12px;object-fit:cover;border:3px solid #f5a623;">
                                @if($dispLabel)
                                <span style="position:absolute;bottom:4px;right:4px;width:14px;height:14px;border-radius:50%;background:{{ $dispColor }};border:2px solid #fff;" title="{{ $dispLabel }}"></span>
                                @endif
                            </div>
                            {{-- Infos --}}
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-0 fw-bold" style="font-size:15px;">{{ $agent->nom_complet }}</h5>
                                        @if($spe1)
                                        <span style="font-size:11px;color:#2E7D32;font-weight:600;">{{ $spe1 }}</span>
                                        @endif
                                    </div>
                                    <span class="badge-premium ms-2">Premium</span>
                                </div>
                                {{-- Étoiles --}}
                                <div class="d-flex align-items-center gap-1 my-1">
                                    @for($i=1;$i<=5;$i++)
                                        <span style="font-size:13px;color:{{ $i<=round($noteAgent)?'#f5a623':'#ccc' }};">★</span>
                                    @endfor
                                    <span style="font-size:11px;color:#666;">({{ number_format($noteAgent,1) }})</span>
                                </div>
                                <p style="font-size:12px;color:#888;margin-bottom:6px;">
                                    {{ $agent->immos->count() }} annonce(s) · {{ $agent->experience ?? '—' }} d'expérience
                                </p>
                                @if($dispLabel)
                                <span style="font-size:10px;padding:2px 8px;border-radius:20px;background:{{ $dispColor }}22;color:{{ $dispColor }};border:1px solid {{ $dispColor }}44;">● {{ $dispLabel }}</span>
                                @endif
                                {{-- Boutons --}}
                                <div class="d-flex gap-2 mt-2 flex-wrap">
                                    <a href="{{ route('agent.show', $agent->id) }}" class="btn btn-success btn-sm" style="font-size:12px;">Voir le profil</a>
                                    @if($agent->telephone)
                                    <a href="tel:{{ $agent->telephone }}" class="btn btn-sm" style="font-size:12px;border:1px solid #2E7D32;color:#2E7D32;">📞 Appeler</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($agents->where('is_premium', 1)->count() === 0)
            <div class="bg-light p-4 rounded text-center">Aucun agent premium trouvé</div>
            @endif
        </div>
    </section>

    {{-- ===== AGENTS NORMAUX ===== --}}
    <section class="services section" id="section-agents">
        <div class="container">
            <h3 class="mb-3">Agents</h3>
            <div class="row g-3" id="list-agents">
                @foreach ($agents->where('is_premium', 0) as $agent)
                @php
                    $noteAgent  = $agent->noteMoyenne();
                    $agentPhoto = $agent->picture;
                    $spes       = $agent->specialites ?? [];
                    $spesArr    = is_string($spes) ? json_decode($spes, true) : (array)$spes;
                    $spe1       = $spesArr[0] ?? null;
                    $zonesRaw   = $agent->zones ?? [];
                    $zonesArr   = is_string($zonesRaw) ? json_decode($zonesRaw, true) : (array)$zonesRaw;
                    $zones      = implode(', ', $zonesArr ?? []);
                @endphp
                <div class="col-6 col-lg-2 col-sm-4 mb-2 agent-card-wrap"
                     data-nom="{{ strtolower($agent->nom_complet) }}"
                     data-zone="{{ strtolower($zones) }}"
                     data-dispo="{{ $agent->disponibilite ?? '' }}">
                    @include('template.components.c_agent', [
                        'title'      => $agent->nom_complet,
                        'info'       => $agent->annonces->count() ? '+'.$agent->annonces->count().' propriété(s)' : 'Aucune propriété',
                        'img'        => asset($agentPhoto),
                        'tel'        => $agent->telephone,
                        'note'       => $noteAgent,
                        'dispo'      => $agent->disponibilite,
                        'specialite' => $spe1,
                        'profil_url' => route('agent.show', $agent->id),
                    ])
                </div>
                @endforeach
            </div>

            {{ $agents->links('pagination::bootstrap-4') }}

            @if($agents->where('is_premium', 0)->count() === 0)
            <div class="bg-light p-4 rounded text-center">Aucun agent trouvé</div>
            @endif
        </div>
    </section>

    <div id="no-results" class="container text-center py-4 d-none">
        <p class="text-muted">Aucun agent ne correspond à votre recherche.</p>
    </div>
@endsection

@section('scriptBottom')
<script>
function filterAgents() {
    const nom   = document.getElementById('filterNom').value.toLowerCase().trim();
    const zone  = document.getElementById('filterZone').value.toLowerCase().trim();
    const dispo = document.getElementById('filterDispo').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.agent-card-wrap');
    let visible = 0;

    cards.forEach(card => {
        const cardNom  = card.dataset.nom  || '';
        const cardZone = card.dataset.zone || '';
        const cardDisp = card.dataset.dispo || '';

        const matchNom  = !nom  || cardNom.includes(nom);
        const matchZone = !zone || cardZone.includes(zone);
        const matchDisp = !dispo || cardDisp === dispo;

        if (matchNom && matchZone && matchDisp) {
            card.style.display = '';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('no-results').classList.toggle('d-none', visible > 0);
}
</script>
@endsection
