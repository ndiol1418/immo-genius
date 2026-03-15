@extends('layouts.accueil')
@section('title', 'Gestion Locative | '.config('app.name'))
@section('content')
<div style="margin-top:80px;padding:20px;">
  <div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
      <div class="col-12">
        <div class="p-4 rounded-3" style="background:#0d1c2e;color:#fff;">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
              <h4 class="mb-1 fw-bold">🏘️ Gestion Locative</h4>
              <p class="mb-0 text-secondary" style="font-size:13px;">Gérez vos contrats de location et suivez les paiements</p>
            </div>
            <a href="{{ route('gestion-locative.create') }}" class="btn btn-sm" style="background:#27E3C0;color:#0d1c2e;font-weight:700;border-radius:20px;">
              + Nouveau contrat
            </a>
          </div>
        </div>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Stats rapides --}}
    <div class="row g-3 mb-4">
      @php
        $actifs   = $contrats->where('statut','actif')->count();
        $signes   = $contrats->where('contrat_signe',true)->count();
        $retards  = $contrats->filter(fn($c) => $c->paiementDuMois() && $c->paiementDuMois()->statut === 'retard')->count();
        $totalLoyer = $contrats->where('statut','actif')->sum('loyer_mensuel');
      @endphp
      @foreach([
        ['Contrats actifs', $actifs, '📋', '#27E3C0'],
        ['Signés', $signes, '✍️', '#0d1c2e'],
        ['En retard ce mois', $retards, '⚠️', '#e74c3c'],
        ['Loyer mensuel total', number_format($totalLoyer,0,',',' ').' CFA', '💰', '#27E3C0'],
      ] as [$label,$val,$icon,$color])
      <div class="col-6 col-lg-3">
        <div class="card shadow-sm text-center p-3" style="border-radius:12px;border-top:3px solid {{ $color }}">
          <div style="font-size:24px;">{{ $icon }}</div>
          <div style="font-size:20px;font-weight:800;color:{{ $color }};">{{ $val }}</div>
          <div style="font-size:11px;color:#666;">{{ $label }}</div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Table des contrats --}}
    <div class="card shadow-sm" style="border-radius:12px;overflow:hidden;">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0" style="font-size:13px;">
            <thead style="background:#0d1c2e;color:#fff;">
              <tr>
                <th class="p-3">Bien</th>
                <th>Locataire</th>
                <th>Loyer</th>
                <th>Mois en cours</th>
                <th>Contrat</th>
                <th>Statut</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($contrats as $c)
                @php $pm = $c->paiementDuMois(); @endphp
                <tr>
                  <td class="p-3">
                    <div style="font-weight:600;">{{ \Str::limit($c->annonce?->name ?? '#'.$c->annonce_id, 28) }}</div>
                    <div style="font-size:11px;color:#888;">{{ $c->date_debut->format('d/m/Y') }} → {{ $c->date_fin?->format('d/m/Y') ?? '∞' }}</div>
                  </td>
                  <td>{{ $c->locataire?->name ?? $c->locataire?->email ?? '#'.$c->locataire_id }}</td>
                  <td><strong>{{ number_format($c->loyer_mensuel,0,',',' ') }}</strong> CFA</td>
                  <td>
                    @if(!$pm)
                      <span class="badge bg-secondary">Non renseigné</span>
                    @elseif($pm->statut === 'paye')
                      <span class="badge" style="background:#27E3C0;color:#0d1c2e;">✓ Payé</span>
                    @elseif($pm->statut === 'retard')
                      <span class="badge bg-danger">⚠ Retard</span>
                    @else
                      <span class="badge bg-warning text-dark">⏳ En attente</span>
                    @endif
                  </td>
                  <td>
                    @if($c->contrat_signe)
                      <span class="badge" style="background:#d1fae5;color:#065f46;">✍️ Signé</span>
                    @else
                      <span class="badge bg-light text-dark">Non signé</span>
                    @endif
                  </td>
                  <td>
                    <span class="badge {{ $c->statut === 'actif' ? 'bg-success' : ($c->statut === 'expire' ? 'bg-secondary' : 'bg-danger') }}">
                      {{ ucfirst($c->statut) }}
                    </span>
                  </td>
                  <td>
                    <a href="{{ route('gestion-locative.show', $c->id) }}" class="btn btn-xs btn-sm" style="background:#27E3C0;color:#0d1c2e;font-size:11px;border-radius:10px;">
                      Voir
                    </a>
                  </td>
                </tr>
              @empty
                <tr><td colspan="7" class="text-center p-4 text-muted">Aucun contrat pour le moment.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
