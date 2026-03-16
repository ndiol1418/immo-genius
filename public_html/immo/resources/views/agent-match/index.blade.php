@extends('layouts.accueil')
@section('title', 'Trouver mon agent — ' . config('app.name'))

@section('content')
<section class="section" style="padding-top:110px;min-height:80vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        {{-- En-tête --}}
        <div class="text-center mb-5">
          <div style="font-size:48px;margin-bottom:12px;">🎯</div>
          <h3 class="fw-bold">Trouver mon agent idéal</h3>
          <p class="text-muted" style="font-size:14px;">Notre IA analyse tous les agents et vous recommande le meilleur selon votre projet</p>
        </div>

        {{-- Formulaire --}}
        <div class="card border-0 shadow-sm p-4 mb-5" style="border-radius:16px;">
          <form method="POST" action="{{ route('agent.match.post') }}">
            @csrf
            <div class="row g-3">

              <div class="col-md-6">
                <label class="form-label fw-bold" style="font-size:13px;">Type de transaction *</label>
                <select name="type_transaction" class="form-control" required>
                  <option value="">— Choisir —</option>
                  <option value="acheter"  @if(old('type_transaction', $typeTransaction??'')=='acheter') selected @endif>🏠 Acheter</option>
                  <option value="louer"    @if(old('type_transaction', $typeTransaction??'')=='louer') selected @endif>🔑 Louer</option>
                  <option value="vendre"   @if(old('type_transaction', $typeTransaction??'')=='vendre') selected @endif>💰 Vendre</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold" style="font-size:13px;">Type de bien</label>
                <select name="type_bien" class="form-control">
                  <option value="">— Tous types —</option>
                  @foreach($typeImmos as $t)
                    <option value="{{ $t->id }}" @if(old('type_bien', $typeBien??'')==$t->id) selected @endif>{{ $t->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold" style="font-size:13px;">Commune / Quartier</label>
                <select name="commune_id" class="form-control select2">
                  <option value="">— Toutes communes —</option>
                  @foreach($communes as $c)
                    <option value="{{ $c->id }}" @if(old('commune_id', $communeId??'')==$c->id) selected @endif>{{ $c->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold" style="font-size:13px;">Budget (CFA)</label>
                <input type="number" name="budget" class="form-control" min="0" placeholder="Ex: 50 000 000"
                  value="{{ old('budget') }}">
              </div>

              <div class="col-12 text-center">
                <button type="submit" class="btn btn-lg px-5"
                  style="background:#2E7D32;color:#fff;border-radius:12px;font-weight:700;font-size:15px;">
                  Trouver mon agent idéal 🎯
                </button>
              </div>
            </div>
          </form>
        </div>

        {{-- Résultats --}}
        @isset($top3)
        <h5 class="fw-bold mb-4 text-center">🏆 Les 3 meilleurs agents pour votre projet</h5>

        @foreach($top3 as $i => $item)
        @php
          $agent = $item['agent'];
          $score = $item['score'];
          $photo = $agent->picture ? asset($agent->picture) : asset('img/user.png');
          $note  = $agent->noteMoyenne();
          $nbAvis = $agent->avis()->count();
          $nbAnnonces = $agent->mes_annonces()->count();
        @endphp

        <div class="card border-0 shadow-sm mb-3 p-4" style="border-radius:16px;{{ $i===0 ? 'border-left:5px solid #2E7D32 !important;' : '' }}">
          <div class="d-flex gap-3 align-items-start flex-wrap">

            {{-- Photo --}}
            <div style="position:relative;flex-shrink:0;">
              <img src="{{ $photo }}" alt="{{ $agent->nom_complet }}"
                style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid {{ $i===0 ? '#2E7D32' : '#eee' }};">
              {{-- Disponibilité --}}
              <span style="position:absolute;bottom:2px;right:2px;width:16px;height:16px;background:{{ $agent->disponibilite_color }};border-radius:50%;border:2px solid #fff;display:block;"></span>
            </div>

            {{-- Infos --}}
            <div class="flex-grow-1">
              <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                <h6 class="mb-0 fw-bold">{{ $agent->nom_complet }}</h6>
                @if($i === 0)
                  <span class="badge px-3 py-1" style="background:#2E7D32;font-size:11px;border-radius:20px;">✨ Meilleur match</span>
                @endif
              </div>

              {{-- Score --}}
              <div class="mb-2">
                <div class="d-flex align-items-center gap-2">
                  <div style="flex:1;height:8px;background:#e9ecef;border-radius:8px;overflow:hidden;">
                    <div style="height:100%;width:{{ $score }}%;background:{{ $i===0?'#2E7D32':($i===1?'#C49A0C':'#6c757d') }};border-radius:8px;"></div>
                  </div>
                  <span class="fw-bold" style="font-size:14px;color:{{ $i===0?'#2E7D32':($i===1?'#C49A0C':'#6c757d') }};">{{ $score }}% compatible</span>
                </div>
              </div>

              {{-- Stats --}}
              <div class="d-flex flex-wrap gap-3" style="font-size:12px;color:#666;">
                <span>⭐ {{ $note }}/5 ({{ $nbAvis }} avis)</span>
                <span>🏠 {{ $nbAnnonces }} annonce(s)</span>
                @if($agent->experience_annees)
                  <span>📅 {{ $agent->experience_annees }} ans d'expérience</span>
                @endif
                @if($agent->disponibilite)
                  <span style="color:{{ $agent->disponibilite_color }};">● {{ ucfirst($agent->disponibilite) }}</span>
                @endif
              </div>

              {{-- Spécialités --}}
              @if($agent->specialites && count($agent->specialites))
              <div class="mt-2 d-flex flex-wrap gap-1">
                @foreach(array_slice($agent->specialites, 0, 3) as $spec)
                  <span class="badge" style="background:#f1f8e9;color:#2E7D32;font-size:10px;border:1px solid #2E7D32;">{{ $spec }}</span>
                @endforeach
              </div>
              @endif
            </div>

            {{-- Boutons --}}
            <div class="d-flex flex-column gap-2" style="min-width:150px;">
              <a href="{{ route('agent.show', $agent->id) }}" class="btn btn-sm"
                style="background:#0d1c2e;color:#fff;border-radius:8px;font-size:12px;">
                👤 Voir son profil
              </a>
              @if($agent->telephone)
              <a href="tel:{{ $agent->telephone }}" class="btn btn-sm"
                style="background:#2E7D32;color:#fff;border-radius:8px;font-size:12px;">
                📞 Contacter
              </a>
              @endif
              @auth
              <a href="{{ route('messages.contact', $agent->mes_annonces()->first()?->id ?? 0) }}" class="btn btn-sm"
                style="background:#f1f8e9;color:#2E7D32;border:1px solid #2E7D32;border-radius:8px;font-size:12px;">
                💬 Message
              </a>
              @endauth
            </div>

          </div>
        </div>
        @endforeach
        @endisset

      </div>
    </div>
  </div>
</section>
@endsection
