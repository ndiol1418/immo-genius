@extends('layouts.accueil')

@section('title', 'Mes Alertes — ' . config('app.name'))

@section('content')
<style>
  .alerte-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 16px 20px; margin-bottom: 14px; }
  .alerte-card.inactive { opacity: .55; }
  .badge-critere { display: inline-block; background: #f0fdf9; border: 1px solid #2E7D32; color: #059669; border-radius: 20px; padding: 2px 10px; font-size: 11px; margin: 2px 3px; }
  .toggle-btn { background: none; border: 1px solid #2E7D32; border-radius: 20px; padding: 4px 14px; font-size: 12px; color: #2E7D32; cursor: pointer; }
  .toggle-btn.inactive { border-color: #ccc; color: #999; }
</style>
<section class="services section mt-4" style="min-height: 60vh;">
  <div class="container" style="margin-top: 100px; max-width: 800px;">
    @if(session('success'))
      <div class="alert alert-success" style="border-radius:10px;">{{ session('success') }}</div>
    @endif

    <div class="row">
      <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
          <div class="card-body p-4">
            <h5 class="mb-3" style="color:#061630;">
              <svg xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 24 24" style="color:#2E7D32"><path fill="currentColor" d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2m6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1z"/></svg>
              Créer une alerte
            </h5>
            <form method="POST" action="{{ route('alertes.store') }}">
              @csrf
              <div class="mb-2">
                <label style="font-size:12px;font-weight:600;">Transaction</label>
                <select name="type_transaction" class="form-control form-control-sm" style="border-radius:8px;">
                  <option value="">Tout</option>
                  <option value="louer" {{ request('type_transaction') == 'louer' ? 'selected' : '' }}>À Louer</option>
                  <option value="acheter" {{ request('type_transaction') == 'acheter' ? 'selected' : '' }}>À Acheter</option>
                </select>
              </div>
              <div class="mb-2">
                <label style="font-size:12px;font-weight:600;">Type de bien</label>
                <select name="type_bien" class="form-control form-control-sm" style="border-radius:8px;">
                  <option value="">Tout</option>
                  @foreach($type_immos as $t)
                    <option value="{{ $t->name }}" {{ request('type_bien') == $t->name ? 'selected' : '' }}>{{ $t->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-2">
                <label style="font-size:12px;font-weight:600;">Région</label>
                <select name="region" class="form-control form-control-sm" style="border-radius:8px;">
                  <option value="">Toutes</option>
                  @foreach($regions ?? [] as $reg)
                    <option value="{{ $reg->name }}" {{ request('region') == $reg->name ? 'selected' : '' }}>{{ $reg->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-2">
                <label style="font-size:12px;font-weight:600;">Commune</label>
                <input type="text" name="commune" class="form-control form-control-sm" placeholder="Ex : Almadies" value="{{ request('commune') }}" style="border-radius:8px;">
              </div>
              <div class="row">
                <div class="col-6 mb-2">
                  <label style="font-size:12px;font-weight:600;">Prix min (CFA)</label>
                  <input type="number" name="prix_min" class="form-control form-control-sm" placeholder="50000" value="{{ request('prix_min') }}" style="border-radius:8px;">
                </div>
                <div class="col-6 mb-2">
                  <label style="font-size:12px;font-weight:600;">Prix max (CFA)</label>
                  <input type="number" name="prix_max" class="form-control form-control-sm" placeholder="300000" value="{{ request('prix_max') }}" style="border-radius:8px;">
                </div>
              </div>
              <div class="mb-3">
                <label style="font-size:12px;font-weight:600;">Chambres min</label>
                <input type="number" name="chambres_min" class="form-control form-control-sm" placeholder="1" value="{{ request('chambres_min') }}" min="0" style="border-radius:8px;">
              </div>
              <button type="submit" class="btn btn-sm w-100" style="background:#2E7D32;color:#fff;border-radius:8px;">
                Créer l'alerte
              </button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <h5 class="mb-3" style="color:#061630;">
          Mes alertes actives
          <span class="badge" style="background:#2E7D32;color:#fff;border-radius:20px;font-size:12px;">{{ $alertes->count() }}</span>
        </h5>

        @if($alertes->isEmpty())
          <div class="text-center py-5 text-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" style="color:#ddd"><path fill="currentColor" d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2m6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1z"/></svg>
            <p class="mt-2">Aucune alerte créée</p>
          </div>
        @else
          @foreach($alertes as $alerte)
          <div class="alerte-card {{ !$alerte->actif ? 'inactive' : '' }}">
            <div class="d-flex justify-content-between align-items-start">
              <div class="flex-grow-1">
                @if($alerte->type_transaction) <span class="badge-critere">{{ ucfirst($alerte->type_transaction) }}</span> @endif
                @if($alerte->type_bien) <span class="badge-critere">{{ $alerte->type_bien }}</span> @endif
                @if($alerte->region) <span class="badge-critere">{{ $alerte->region }}</span> @endif
                @if($alerte->commune) <span class="badge-critere">{{ $alerte->commune }}</span> @endif
                @if($alerte->prix_min) <span class="badge-critere">Min {{ number_format($alerte->prix_min, 0, '', ' ') }} CFA</span> @endif
                @if($alerte->prix_max) <span class="badge-critere">Max {{ number_format($alerte->prix_max, 0, '', ' ') }} CFA</span> @endif
                @if($alerte->chambres_min) <span class="badge-critere">{{ $alerte->chambres_min }}+ chambres</span> @endif
                <p style="font-size:10px;color:#aaa;margin-top:6px;margin-bottom:0;">Créée {{ $alerte->created_at->diffForHumans() }}</p>
              </div>
              <div class="d-flex align-items-center" style="gap:6px;flex-shrink:0;margin-left:10px;">
                <form method="POST" action="{{ route('alertes.toggle', $alerte->id) }}">
                  @csrf
                  <button type="submit" class="toggle-btn {{ !$alerte->actif ? 'inactive' : '' }}">
                    {{ $alerte->actif ? 'Active' : 'Inactive' }}
                  </button>
                </form>
                <form method="POST" action="{{ route('alertes.destroy', $alerte->id) }}" onsubmit="return confirm('Supprimer cette alerte ?')">
                  @csrf @method('DELETE')
                  <button type="submit" style="background:none;border:none;color:#e74c3c;cursor:pointer;padding:4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z"/></svg>
                  </button>
                </form>
              </div>
            </div>
          </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
