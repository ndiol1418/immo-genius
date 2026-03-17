@php
    $noteVal   = $note ?? 0;
    $nbEtoiles = round($noteVal);
    $telRaw    = preg_replace('/[^0-9]/', '', $tel ?? '');
    $telValide = strlen($telRaw) >= 8;
    $dispColor = match($dispo ?? '') {
        'disponible' => '#2E7D32', 'occupe' => '#C49A0C', 'conge' => '#dc3545', default => '#aaa'
    };
    $dispLabel = match($dispo ?? '') {
        'disponible' => 'Disponible', 'occupe' => 'Occupé', 'conge' => 'En congé', default => null
    };
@endphp
<div class="card h-100" style="border-radius:12px;border:1px solid #e8e8e8;overflow:hidden;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 18px rgba(0,0,0,.12)'" onmouseout="this.style.boxShadow='none'">
    <div class="card-body p-3 d-flex flex-column align-items-center text-center">

        {{-- Avatar --}}
        <div class="position-relative mb-2">
            <img src="{{ $img ?? 'https://ui-avatars.com/api/?name=Agent&background=2E7D32&color=fff&size=128&bold=true' }}"
                 alt="{{ $title ?? 'Agent' }}"
                 style="width:70px;height:70px;border-radius:50%;object-fit:cover;border:3px solid #2E7D32;">
            @if($dispLabel)
            <span style="position:absolute;bottom:2px;right:2px;width:13px;height:13px;border-radius:50%;background:{{ $dispColor }};border:2px solid #fff;" title="{{ $dispLabel }}"></span>
            @endif
        </div>

        {{-- Nom --}}
        <p class="mb-0 fw-semibold" style="font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:100%;" title="{{ $title ?? '' }}">{{ $title ?? '' }}</p>

        {{-- Spécialité --}}
        @if(!empty($specialite))
        <span style="font-size:10px;color:#2E7D32;font-weight:600;">{{ $specialite }}</span>
        @endif

        {{-- Étoiles + note --}}
        <div class="d-flex align-items-center gap-1 my-1">
            @for($i = 1; $i <= 5; $i++)
                <span style="font-size:12px;color:{{ $i <= $nbEtoiles ? '#f5a623' : '#ccc' }};">★</span>
            @endfor
            <span style="font-size:11px;color:#666;">({{ number_format($noteVal, 1) }})</span>
        </div>

        {{-- Propriétés --}}
        <p class="mb-1" style="font-size:11px;color:#888;">{{ $info ?? '' }}</p>

        {{-- Badge dispo --}}
        @if($dispLabel)
        <span class="mb-2" style="font-size:10px;padding:2px 8px;border-radius:20px;background:{{ $dispColor }}22;color:{{ $dispColor }};border:1px solid {{ $dispColor }}44;">● {{ $dispLabel }}</span>
        @endif

        {{-- Boutons --}}
        <div class="d-flex gap-1 w-100 mt-auto">
            <a href="{{ $profil_url ?? '#' }}" class="btn btn-success btn-sm flex-fill" style="font-size:11px;">Voir profil</a>
            @if($telValide)
            <a href="tel:{{ $tel }}" class="btn btn-sm flex-fill" style="font-size:11px;border:1px solid #2E7D32;color:#2E7D32;background:#fff;">Contacter</a>
            @endif
        </div>

    </div>
</div>
