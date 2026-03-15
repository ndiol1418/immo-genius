@extends('layouts.accueil')

@section('title', 'Comparer des annonces — ' . config('app.name'))

@section('content')
<section class="section mt-4" style="min-height: 60vh;">
  <div class="container" style="margin-top: 100px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
      <h4 class="mb-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/></svg>
        Comparaison d'annonces
      </h4>
      <a href="javascript:history.back()" class="btn btn-sm btn-light">← Retour</a>
    </div>

    @if($annonces->isEmpty())
      <div class="text-center py-5">
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" style="color:#ccc;"><path fill="currentColor" d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/></svg>
        <p class="mt-3 text-muted">Aucune annonce à comparer.</p>
        <p class="text-muted" style="font-size:13px;">Ajoutez des annonces à la comparaison depuis les fiches.</p>
        <a href="{{ route('louer') }}" class="btn btn-primary mt-2">Parcourir les annonces</a>
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-bordered align-middle" style="min-width:600px;">
          <thead class="table-light">
            <tr>
              <th style="width:180px;">Critère</th>
              @foreach($annonces as $a)
                <th class="text-center">
                  <div class="position-relative">
                    @if($a->images->isNotEmpty())
                      <img src="{{ asset($a->images->first()->url) }}" alt="" class="rounded mb-1" style="width:100%;height:120px;object-fit:cover;">
                    @else
                      <div class="rounded mb-1 bg-light d-flex align-items-center justify-content-center" style="height:120px;"><span class="text-muted">Pas de photo</span></div>
                    @endif
                    <button onclick="removeFromCompare({{ $a->id }}, this)" class="btn btn-sm btn-light position-absolute" style="top:4px;right:4px;padding:2px 6px;font-size:11px;" title="Retirer">✕</button>
                  </div>
                  <a href="{{ route('annonce', $a->slug) }}" class="d-block text-dark fw-bold" style="font-size:13px;">{{ Str::limit($a->name, 40) }}</a>
                </th>
              @endforeach
              @if($annonces->count() < 3)
                <th class="text-center text-muted" style="vertical-align:middle;">
                  <a href="{{ route('louer') }}" class="text-muted d-block">
                    <span style="font-size:30px;">+</span><br>
                    <small>Ajouter une annonce</small>
                  </a>
                </th>
              @endif
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fw-bold bg-light">Prix</td>
              @foreach($annonces as $a)
                <td class="text-center fw-bold text-primary">{{ number_format($a->prix, 0, ',', ' ') }} CFA</td>
              @endforeach
              @if($annonces->count() < 3)<td></td>@endif
            </tr>
            <tr>
              <td class="bg-light">Type</td>
              @foreach($annonces as $a)
                <td class="text-center">{{ $a->typeLocation?->name ?? '—' }}</td>
              @endforeach
              @if($annonces->count() < 3)<td></td>@endif
            </tr>
            <tr>
              <td class="bg-light">Superficie</td>
              @foreach($annonces as $a)
                <td class="text-center">{{ $a->surface ? $a->surface . ' m²' : '—' }}</td>
              @endforeach
              @if($annonces->count() < 3)<td></td>@endif
            </tr>
            <tr>
              <td class="bg-light">Chambres</td>
              @foreach($annonces as $a)
                @php $chambres = $a->pieces->where('Chambres', '>', 0)->first(); @endphp
                <td class="text-center">{{ $chambres ? $chambres->Chambres : '—' }}</td>
              @endforeach
              @if($annonces->count() < 3)<td></td>@endif
            </tr>
            <tr>
              <td class="bg-light">Localisation</td>
              @foreach($annonces as $a)
                <td class="text-center" style="font-size:13px;">
                  {{ $a->commune?->name ?? '—' }}
                  @if($a->commune?->departement)<br><small class="text-muted">{{ $a->commune->departement->name }}</small>@endif
                </td>
              @endforeach
              @if($annonces->count() < 3)<td></td>@endif
            </tr>
            <tr>
              <td class="bg-light">Meublé</td>
              @foreach($annonces as $a)
                <td class="text-center">
                  @if($a->meuble)
                    <span class="badge bg-success">Oui</span>
                  @else
                    <span class="badge bg-secondary">Non</span>
                  @endif
                </td>
              @endforeach
              @if($annonces->count() < 3)<td></td>@endif
            </tr>
            <tr>
              <td class="bg-light">Visite 360°</td>
              @foreach($annonces as $a)
                <td class="text-center">
                  @if($a->visite_virtuelle_type)
                    <span class="badge bg-primary">Disponible</span>
                  @else
                    <span style="color:#ccc;">—</span>
                  @endif
                </td>
              @endforeach
              @if($annonces->count() < 3)<td></td>@endif
            </tr>
            <tr>
              <td class="bg-light">Prix/m²</td>
              @foreach($annonces as $a)
                <td class="text-center" style="font-size:13px;">
                  @if($a->surface > 0)
                    {{ number_format($a->prix / $a->surface, 0, ',', ' ') }} CFA/m²
                  @else
                    —
                  @endif
                </td>
              @endforeach
              @if($annonces->count() < 3)<td></td>@endif
            </tr>
            <tr>
              <td class="bg-light"></td>
              @foreach($annonces as $a)
                <td class="text-center">
                  <a href="{{ route('annonce', $a->slug) }}" class="btn btn-sm btn-primary">Voir l'annonce</a>
                </td>
              @endforeach
              @if($annonces->count() < 3)<td></td>@endif
            </tr>
          </tbody>
        </table>
      </div>
    @endif

  </div>
</section>
@endsection

@section('scriptBottom')
<script>
function removeFromCompare(id, btn) {
    let stored = JSON.parse(localStorage.getItem('compareIds') || '[]');
    stored = stored.filter(x => x != id);
    localStorage.setItem('compareIds', JSON.stringify(stored));
    // Reload page with updated ids
    const ids = stored.join(',');
    window.location.href = '{{ route("comparer") }}' + (ids ? '?ids=' + ids : '');
}
// Sync localStorage with current URL
document.addEventListener('DOMContentLoaded', function() {
    const urlIds = new URLSearchParams(window.location.search).get('ids');
    if (urlIds) {
        const arr = urlIds.split(',').filter(Boolean);
        localStorage.setItem('compareIds', JSON.stringify(arr));
    }
});
</script>
@endsection
