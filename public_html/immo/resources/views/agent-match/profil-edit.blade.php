@extends('layouts.accueil')
@section('title', 'Mon profil agent — ' . config('app.name'))

@section('content')
<section class="section" style="padding-top:110px;min-height:80vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <h4 class="fw-bold mb-4">✏️ Mon profil agent</h4>

        @if(session('success'))
          <div class="alert alert-success rounded-3">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('agent.profil.update') }}">
          @csrf
          <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px;">
            <h6 class="fw-bold mb-3">📋 Informations professionnelles</h6>
            <div class="row g-3">

              <div class="col-12">
                <label class="form-label fw-bold" style="font-size:13px;">Description professionnelle</label>
                <textarea name="description_pro" class="form-control" rows="4" placeholder="Décrivez votre expertise, vos services...">{{ old('description_pro', $agent->description_pro) }}</textarea>
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold" style="font-size:13px;">Années d'expérience</label>
                <input type="number" name="experience_annees" class="form-control" min="0" max="50"
                  value="{{ old('experience_annees', $agent->experience_annees ?? 0) }}">
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold" style="font-size:13px;">Disponibilité</label>
                <select name="disponibilite" class="form-control">
                  <option value="disponible" @if(($agent->disponibilite??'disponible')=='disponible') selected @endif>🟢 Disponible</option>
                  <option value="occupe"     @if(($agent->disponibilite??'')=='occupe') selected @endif>🟡 Occupé</option>
                  <option value="conge"      @if(($agent->disponibilite??'')=='conge') selected @endif>🔴 En congé</option>
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold" style="font-size:13px;">Certifications (séparées par virgule)</label>
                <input type="text" name="certifications" class="form-control" placeholder="Ex: FNAIM, SNPI..."
                  value="{{ old('certifications', implode(', ', $agent->certifications ?? [])) }}">
              </div>

            </div>
          </div>

          {{-- Spécialités --}}
          <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px;">
            <h6 class="fw-bold mb-3">🏷️ Spécialités</h6>
            @php
              $specialitesList = ['Location', 'Vente', 'Commercial', 'Résidentiel', 'Luxe', 'Terrain', 'Investissement'];
              $selectedSpecs   = $agent->specialites ?? [];
            @endphp
            <div class="d-flex flex-wrap gap-2">
              @foreach($specialitesList as $spec)
              <label style="cursor:pointer;">
                <input type="checkbox" name="specialites[]" value="{{ $spec }}"
                  @if(in_array($spec, $selectedSpecs)) checked @endif style="display:none;" class="spec-cb">
                <span class="badge px-3 py-2 spec-label" style="font-size:12px;border-radius:20px;border:2px solid #2E7D32;cursor:pointer;
                  {{ in_array($spec, $selectedSpecs) ? 'background:#2E7D32;color:#fff;' : 'background:#fff;color:#2E7D32;' }}">
                  {{ $spec }}
                </span>
              </label>
              @endforeach
            </div>
          </div>

          {{-- Réseaux sociaux --}}
          <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px;">
            <h6 class="fw-bold mb-3">🌐 Réseaux sociaux</h6>
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label" style="font-size:12px;">Facebook</label>
                <input type="url" name="facebook" class="form-control" placeholder="https://facebook.com/..."
                  value="{{ old('facebook', $agent->reseaux_sociaux['facebook'] ?? '') }}">
              </div>
              <div class="col-md-4">
                <label class="form-label" style="font-size:12px;">LinkedIn</label>
                <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/..."
                  value="{{ old('linkedin', $agent->reseaux_sociaux['linkedin'] ?? '') }}">
              </div>
              <div class="col-md-4">
                <label class="form-label" style="font-size:12px;">Instagram</label>
                <input type="url" name="instagram" class="form-control" placeholder="https://instagram.com/..."
                  value="{{ old('instagram', $agent->reseaux_sociaux['instagram'] ?? '') }}">
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-lg px-5"
            style="background:#2E7D32;color:#fff;border-radius:10px;font-weight:600;">
            💾 Enregistrer mon profil
          </button>
        </form>

        {{-- Créneaux de disponibilité --}}
        <div class="card border-0 shadow-sm p-4 mt-4 mb-5" style="border-radius:16px;">
          <h6 class="fw-bold mb-3">📅 Mes créneaux de disponibilité</h6>

          @if(session('success') && str_contains(session('success'), 'Créneau'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          {{-- Ajouter un créneau --}}
          <form method="POST" action="{{ route('disponibilite.store') }}" class="mb-4">
            @csrf
            <div class="row g-2 align-items-end">
              <div class="col-md-3">
                <label style="font-size:12px;">Date</label>
                <input type="date" name="date" class="form-control" min="{{ date('Y-m-d') }}" required>
              </div>
              <div class="col-md-2">
                <label style="font-size:12px;">Début</label>
                <input type="time" name="heure_debut" class="form-control" required>
              </div>
              <div class="col-md-2">
                <label style="font-size:12px;">Fin</label>
                <input type="time" name="heure_fin" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label style="font-size:12px;">Type</label>
                <select name="type_rdv" class="form-control">
                  <option value="visite">Visite</option>
                  <option value="consultation">Consultation</option>
                  <option value="signature">Signature</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn w-100" style="background:#2E7D32;color:#fff;border-radius:8px;">+ Ajouter</button>
              </div>
            </div>
          </form>

          {{-- Liste des créneaux --}}
          @php $creneaux = $agent->disponibilites()->orderBy('date')->orderBy('heure_debut')->limit(20)->get(); @endphp
          @if($creneaux->isEmpty())
            <p class="text-muted" style="font-size:13px;">Aucun créneau ajouté.</p>
          @else
          <div class="table-responsive">
            <table class="table table-sm" style="font-size:12px;">
              <thead><tr><th>Date</th><th>Horaire</th><th>Type</th><th>Statut</th><th></th></tr></thead>
              <tbody>
                @foreach($creneaux as $c)
                <tr>
                  <td>{{ $c->date->format('d/m/Y') }}</td>
                  <td>{{ substr($c->heure_debut,0,5) }} – {{ substr($c->heure_fin,0,5) }}</td>
                  <td>{{ ucfirst($c->type_rdv) }}</td>
                  <td>
                    <span class="badge" style="background:{{ $c->statut==='disponible'?'#2E7D32':($c->statut==='reserve'?'#C49A0C':'#dc3545') }};">
                      {{ ucfirst($c->statut) }}
                    </span>
                  </td>
                  <td>
                    <form method="POST" action="{{ route('disponibilite.destroy', $c->id) }}" onsubmit="return confirm('Supprimer ?')">
                      @csrf @method('DELETE')
                      <button type="submit" style="background:none;border:none;color:#dc3545;font-size:12px;cursor:pointer;">✕</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif
        </div>

      </div>
    </div>
  </div>
</section>

<script>
// Toggle spécialités
document.querySelectorAll('.spec-cb').forEach(function(cb){
  cb.addEventListener('change', function(){
    var label = this.nextElementSibling;
    if(this.checked){
      label.style.background='#2E7D32';
      label.style.color='#fff';
    } else {
      label.style.background='#fff';
      label.style.color='#2E7D32';
    }
  });
});
</script>
@endsection
