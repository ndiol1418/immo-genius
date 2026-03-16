@extends('layouts.accueil')
@section('title', 'Nouveau Contrat | '.config('app.name'))
@section('content')
<div style="margin-top:80px;padding:20px;">
  <div class="container" style="max-width:700px;">
    <div class="p-4 rounded-3 mb-4" style="background:#0d1c2e;color:#fff;">
      <h4 class="mb-0 fw-bold">📝 Créer un contrat de location</h4>
    </div>
    @if($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <div class="card shadow-sm" style="border-radius:12px;">
      <div class="card-body p-4">
        <form method="POST" action="{{ route('gestion-locative.store') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label fw-semibold">Annonce (bien loué)</label>
            <select name="annonce_id" class="form-control" required>
              <option value="">-- Sélectionner --</option>
              @foreach($annonces as $a)
                <option value="{{ $a->id }}" {{ old('annonce_id') == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Locataire (email ou nom)</label>
            <input type="text" name="locataire_email_hint" list="locataires-list" class="form-control" placeholder="Rechercher un utilisateur..." autocomplete="off">
            <datalist id="locataires-list">
              @foreach($locataires as $u)
                <option value="{{ $u->email }}">{{ $u->name ?? $u->email }}</option>
              @endforeach
            </datalist>
            <select name="locataire_id" class="form-control mt-2" required>
              <option value="">-- Sélectionner le locataire --</option>
              @foreach($locataires as $u)
                <option value="{{ $u->id }}" {{ old('locataire_id') == $u->id ? 'selected' : '' }}>{{ $u->name ?? $u->email }}</option>
              @endforeach
            </select>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-6">
              <label class="form-label fw-semibold">Date de début</label>
              <input type="date" name="date_debut" class="form-control" value="{{ old('date_debut') }}" required>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Date de fin (optionnel)</label>
              <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin') }}">
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-4">
              <label class="form-label fw-semibold">Loyer mensuel (CFA)</label>
              <input type="number" name="loyer_mensuel" class="form-control" value="{{ old('loyer_mensuel') }}" required min="0">
            </div>
            <div class="col-4">
              <label class="form-label fw-semibold">Charges (CFA)</label>
              <input type="number" name="charges" class="form-control" value="{{ old('charges',0) }}" min="0">
            </div>
            <div class="col-4">
              <label class="form-label fw-semibold">Caution (CFA)</label>
              <input type="number" name="caution" class="form-control" value="{{ old('caution',0) }}" min="0">
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn" style="background:#2E7D32;color:#0d1c2e;font-weight:700;border-radius:10px;">
              Créer le contrat
            </button>
            <a href="{{ route('gestion-locative.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
