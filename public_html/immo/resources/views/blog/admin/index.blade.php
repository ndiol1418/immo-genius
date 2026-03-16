@extends('layouts.accueil')
@section('title', 'Gestion du Blog — ' . config('app.name'))

@section('content')
<section class="section" style="padding-top:110px;min-height:80vh;">
<div class="container">

  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">📝 Gestion du Blog</h4>
    <a href="{{ route('blog.create') }}" class="btn btn-sm fw-bold"
       style="background:#2E7D32;color:#fff;border-radius:8px;">
      + Nouvel article
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success rounded-3">{{ session('success') }}</div>
  @endif

  <div class="card border-0 shadow-sm" style="border-radius:16px;overflow:hidden;">
    <div class="table-responsive">
      <table class="table table-sm align-middle mb-0" style="font-size:13px;">
        <thead style="background:#f8f9fa;">
          <tr>
            <th class="px-3 py-3">Titre</th>
            <th>Catégorie</th>
            <th>Statut</th>
            <th class="text-center">Vues</th>
            <th>Date</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($articles as $article)
          @php
            $couleur = $article->categorie_couleur;
            $label   = $article->categorie_libelle;
          @endphp
          <tr>
            <td class="px-3 py-2">
              <a href="{{ route('blog.show', $article->slug) }}" target="_blank" class="text-dark fw-bold text-decoration-none">
                {{ \Str::limit($article->titre, 60) }}
              </a>
            </td>
            <td>
              <span style="background:{{ $couleur }};color:#fff;font-size:10px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $label }}</span>
            </td>
            <td>
              @if($article->statut === 'publie')
                <span class="badge bg-success" style="font-size:10px;">Publié</span>
              @else
                <span class="badge bg-secondary" style="font-size:10px;">Brouillon</span>
              @endif
            </td>
            <td class="text-center fw-bold">{{ number_format($article->vues) }}</td>
            <td style="color:#888;">{{ $article->created_at->format('d/m/Y') }}</td>
            <td class="text-center">
              <div class="d-flex gap-1 justify-content-center">
                <a href="{{ route('blog.edit', $article->id) }}"
                   style="background:#0d1c2e;color:#fff;border-radius:6px;padding:3px 10px;font-size:11px;text-decoration:none;">✏️ Éditer</a>
                <form method="POST" action="{{ route('blog.toggle', $article->id) }}" style="display:inline;">
                  @csrf
                  <button type="submit" style="background:{{ $article->statut==='publie'?'#dc3545':'#2E7D32' }};color:#fff;border:none;border-radius:6px;padding:3px 10px;font-size:11px;cursor:pointer;">
                    {{ $article->statut === 'publie' ? '⏸ Dépublier' : '▶ Publier' }}
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted py-4">Aucun article pour l'instant.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-4">{{ $articles->links() }}</div>

</div>
</section>
@endsection
