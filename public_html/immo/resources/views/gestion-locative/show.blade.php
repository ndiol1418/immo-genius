@extends('layouts.accueil')
@section('title', 'Contrat #'.$contrat->id.' | '.config('app.name'))
@section('content')
<div style="margin-top:80px;padding:20px;">
<div class="container" style="max-width:900px;">

  <div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('gestion-locative.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:10px;">← Retour</a>
    <h5 class="mb-0 fw-bold">📄 Contrat #{{ $contrat->id }}</h5>
    @if($contrat->contrat_signe)
      <span class="badge" style="background:#d1fae5;color:#065f46;font-size:12px;">✍️ Signé par les deux parties</span>
    @endif
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
  @endif

  <div class="row g-3 mb-4">
    {{-- Infos contrat --}}
    <div class="col-lg-6">
      <div class="card shadow-sm h-100" style="border-radius:12px;">
        <div class="card-body">
          <h6 class="fw-bold mb-3" style="color:#0d1c2e;">📋 Détails du contrat</h6>
          <table class="table table-sm" style="font-size:13px;">
            <tr><td class="text-muted">Bien</td><td><strong>{{ $contrat->annonce?->name }}</strong></td></tr>
            <tr><td class="text-muted">Locataire</td><td>{{ $contrat->locataire?->name ?? $contrat->locataire?->email }}</td></tr>
            <tr><td class="text-muted">Agent</td><td>{{ $contrat->agent?->name ?? $contrat->agent?->email }}</td></tr>
            <tr><td class="text-muted">Début</td><td>{{ $contrat->date_debut->format('d/m/Y') }}</td></tr>
            <tr><td class="text-muted">Fin</td><td>{{ $contrat->date_fin?->format('d/m/Y') ?? 'Indéterminée' }}</td></tr>
            <tr><td class="text-muted">Loyer</td><td><strong style="color:#2E7D32;">{{ number_format($contrat->loyer_mensuel,0,',',' ') }} CFA</strong></td></tr>
            <tr><td class="text-muted">Charges</td><td>{{ number_format($contrat->charges,0,',',' ') }} CFA</td></tr>
            <tr><td class="text-muted">Caution</td><td>{{ number_format($contrat->caution,0,',',' ') }} CFA</td></tr>
            <tr><td class="text-muted">Statut</td><td><span class="badge {{ $contrat->statut === 'actif' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($contrat->statut) }}</span></td></tr>
          </table>
          <div class="d-flex gap-2 flex-wrap mt-2">
            <a href="{{ route('gestion-locative.pdf', $contrat->id) }}" class="btn btn-sm" style="background:#0d1c2e;color:#2E7D32;border-radius:10px;font-size:12px;">
              📥 Télécharger PDF
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- Enregistrer paiement --}}
    <div class="col-lg-6">
      <div class="card shadow-sm h-100" style="border-radius:12px;">
        <div class="card-body">
          <h6 class="fw-bold mb-3" style="color:#0d1c2e;">💰 Enregistrer un paiement</h6>
          <form method="POST" action="{{ route('gestion-locative.paiement', $contrat->id) }}">
            @csrf
            <div class="mb-2">
              <label class="form-label" style="font-size:12px;">Mois concerné</label>
              <input type="month" name="mois_concerne" class="form-control form-control-sm" value="{{ now()->format('Y-m') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label" style="font-size:12px;">Montant (CFA)</label>
              <input type="number" name="montant" class="form-control form-control-sm" value="{{ $contrat->loyer_mensuel }}" required min="0">
            </div>
            <button type="submit" class="btn btn-sm w-100" style="background:#2E7D32;color:#0d1c2e;font-weight:700;border-radius:10px;">
              ✓ Enregistrer le paiement
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Historique paiements --}}
  <div class="card shadow-sm mb-4" style="border-radius:12px;">
    <div class="card-body">
      <h6 class="fw-bold mb-3" style="color:#0d1c2e;">📊 Historique des paiements</h6>
      @if($contrat->paiements->isEmpty())
        <p class="text-muted" style="font-size:13px;">Aucun paiement enregistré.</p>
      @else
        <div class="table-responsive">
          <table class="table table-sm table-hover" style="font-size:12px;">
            <thead style="background:#f8f9fa;">
              <tr><th>Mois</th><th>Montant</th><th>Date paiement</th><th>Statut</th><th>Quittance</th></tr>
            </thead>
            <tbody>
              @foreach($contrat->paiements->sortByDesc('mois_concerne') as $p)
              <tr>
                <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $p->mois_concerne)->translatedFormat('F Y') }}</td>
                <td>{{ number_format($p->montant,0,',',' ') }} CFA</td>
                <td>{{ $p->date_paiement?->format('d/m/Y') ?? '—' }}</td>
                <td>
                  @if($p->statut === 'paye') <span class="badge" style="background:#2E7D32;color:#0d1c2e;">✓ Payé</span>
                  @elseif($p->statut === 'retard') <span class="badge bg-danger">⚠ Retard</span>
                  @else <span class="badge bg-warning text-dark">⏳ En attente</span>
                  @endif
                </td>
                <td>
                  @if($p->statut === 'paye')
                    <a href="{{ route('gestion-locative.quittance', [$contrat->id, $p->mois_concerne]) }}" class="btn btn-xs" style="font-size:10px;background:#f1f8e9;color:#065f46;border:1px solid #2E7D32;border-radius:8px;padding:2px 8px;">PDF</a>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

  {{-- Signatures --}}
  <div class="card shadow-sm" style="border-radius:12px;">
    <div class="card-body">
      <h6 class="fw-bold mb-3" style="color:#0d1c2e;">✍️ Signatures électroniques</h6>
      <div class="row g-3">
        {{-- Signature Agent --}}
        <div class="col-md-6">
          <div class="p-3 rounded" style="border:1px solid #ddd;background:#fafafa;">
            <p class="fw-semibold mb-2" style="font-size:13px;">Signature de l'agent</p>
            @if($contrat->signature_agent)
              <img src="{{ $contrat->signature_agent }}" style="max-width:100%;border:1px solid #2E7D32;border-radius:8px;" alt="Signature agent">
              <p class="text-muted mt-1" style="font-size:11px;">Signé le {{ $contrat->date_signature_agent?->format('d/m/Y H:i') }}</p>
            @elseif(auth()->id() === $contrat->agent_id)
              <canvas id="canvas-agent" width="280" height="110" style="border:2px dashed #2E7D32;border-radius:8px;cursor:crosshair;background:#fff;display:block;"></canvas>
              <div class="d-flex gap-2 mt-2">
                <button onclick="clearCanvas('canvas-agent')" class="btn btn-sm btn-outline-secondary" style="font-size:11px;border-radius:8px;">Effacer</button>
                <button onclick="soumettreSig('agent','canvas-agent')" class="btn btn-sm" style="background:#2E7D32;color:#0d1c2e;font-size:11px;border-radius:8px;font-weight:700;">Signer</button>
              </div>
            @else
              <p class="text-muted" style="font-size:12px;">En attente de la signature de l'agent</p>
            @endif
          </div>
        </div>
        {{-- Signature Locataire --}}
        <div class="col-md-6">
          <div class="p-3 rounded" style="border:1px solid #ddd;background:#fafafa;">
            <p class="fw-semibold mb-2" style="font-size:13px;">Signature du locataire</p>
            @if($contrat->signature_locataire)
              <img src="{{ $contrat->signature_locataire }}" style="max-width:100%;border:1px solid #2E7D32;border-radius:8px;" alt="Signature locataire">
              <p class="text-muted mt-1" style="font-size:11px;">Signé le {{ $contrat->date_signature_locataire?->format('d/m/Y H:i') }}</p>
            @elseif(auth()->id() === $contrat->locataire_id)
              <canvas id="canvas-locataire" width="280" height="110" style="border:2px dashed #2E7D32;border-radius:8px;cursor:crosshair;background:#fff;display:block;"></canvas>
              <div class="d-flex gap-2 mt-2">
                <button onclick="clearCanvas('canvas-locataire')" class="btn btn-sm btn-outline-secondary" style="font-size:11px;border-radius:8px;">Effacer</button>
                <button onclick="soumettreSig('locataire','canvas-locataire')" class="btn btn-sm" style="background:#2E7D32;color:#0d1c2e;font-size:11px;border-radius:8px;font-weight:700;">Signer</button>
              </div>
            @else
              <p class="text-muted" style="font-size:12px;">En attente de la signature du locataire</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</div>

@push('subScript')
<script>
// Canvas signature drawing
function initCanvas(id) {
    var canvas = document.getElementById(id);
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    var drawing = false;
    ctx.strokeStyle = '#0d1c2e';
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';

    canvas.addEventListener('mousedown', function(e) { drawing = true; ctx.beginPath(); ctx.moveTo(e.offsetX, e.offsetY); });
    canvas.addEventListener('mousemove', function(e) { if (!drawing) return; ctx.lineTo(e.offsetX, e.offsetY); ctx.stroke(); });
    canvas.addEventListener('mouseup', function() { drawing = false; });
    canvas.addEventListener('mouseleave', function() { drawing = false; });

    // Touch support
    canvas.addEventListener('touchstart', function(e) { e.preventDefault(); drawing = true; var t = e.touches[0]; var r = canvas.getBoundingClientRect(); ctx.beginPath(); ctx.moveTo(t.clientX-r.left, t.clientY-r.top); });
    canvas.addEventListener('touchmove', function(e) { e.preventDefault(); if (!drawing) return; var t = e.touches[0]; var r = canvas.getBoundingClientRect(); ctx.lineTo(t.clientX-r.left, t.clientY-r.top); ctx.stroke(); });
    canvas.addEventListener('touchend', function() { drawing = false; });
}

function clearCanvas(id) {
    var canvas = document.getElementById(id);
    if (canvas) canvas.getContext('2d').clearRect(0,0,canvas.width,canvas.height);
}

function soumettreSig(role, canvasId) {
    var canvas = document.getElementById(canvasId);
    var data = canvas.toDataURL('image/png');
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("gestion-locative.signer", $contrat->id) }}';
    var csrf = document.createElement('input'); csrf.type='hidden'; csrf.name='_token'; csrf.value='{{ csrf_token() }}'; form.appendChild(csrf);
    var sig = document.createElement('input'); sig.type='hidden'; sig.name='signature'; sig.value=data; form.appendChild(sig);
    document.body.appendChild(form);
    form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    initCanvas('canvas-agent');
    initCanvas('canvas-locataire');
});
</script>
@endpush
@endsection
