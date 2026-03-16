@extends('layouts.accueil')
@section('title', isset($article) ? 'Modifier l\'article' : 'Nouvel article')

@section('content')
<section class="section" style="padding-top:110px;min-height:80vh;">
<div class="container" style="max-width:860px;">

  <h4 class="fw-bold mb-4">{{ isset($article) ? '✏️ Modifier l\'article' : '📝 Nouvel article' }}</h4>

  @if($errors->any())
    <div class="alert alert-danger rounded-3 mb-4">
      <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="POST"
        action="{{ isset($article) ? route('blog.update', $article->id) : route('blog.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($article)) @method('PUT') @endif

    <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px;">
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label fw-bold" style="font-size:13px;">Titre *</label>
          <input type="text" name="titre" class="form-control" required
                 value="{{ old('titre', $article->titre ?? '') }}" placeholder="Titre de l'article">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold" style="font-size:13px;">Catégorie *</label>
          <select name="categorie" class="form-control" required>
            @foreach(['actualite'=>'Actualité','guide'=>'Guide','conseil'=>'Conseil','marche'=>'Marché','quartier'=>'Quartier'] as $val => $lab)
            <option value="{{ $val }}" {{ old('categorie', $article->categorie ?? '') == $val ? 'selected' : '' }}>{{ $lab }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold" style="font-size:13px;">Statut *</label>
          <select name="statut" class="form-control" required>
            <option value="brouillon" {{ old('statut', $article->statut ?? 'brouillon') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
            <option value="publie"    {{ old('statut', $article->statut ?? '') == 'publie' ? 'selected' : '' }}>Publié</option>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label fw-bold" style="font-size:13px;">Extrait (150 caractères max)</label>
          <textarea name="extrait" class="form-control" rows="2" maxlength="500" placeholder="Résumé court affiché sur la liste...">{{ old('extrait', $article->extrait ?? '') }}</textarea>
        </div>
        <div class="col-12">
          <label class="form-label fw-bold" style="font-size:13px;">Contenu *</label>
          <textarea name="contenu" class="form-control" rows="16" required
                    placeholder="Contenu complet de l'article...">{{ old('contenu', $article->contenu ?? '') }}</textarea>
          <div style="font-size:11px;color:#aaa;margin-top:4px;">Utilisez des sauts de ligne pour structurer le contenu.</div>
        </div>
        <div class="col-12">
          <label class="form-label fw-bold" style="font-size:13px;">Image de couverture</label>
          @if(isset($article) && $article->image_couverture)
            <div class="mb-2"><img src="{{ asset($article->image_couverture) }}" style="height:100px;border-radius:8px;object-fit:cover;"></div>
          @endif
          <input type="file" name="image_couverture" class="form-control" accept="image/*">
        </div>
      </div>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn fw-bold px-5"
              style="background:#2E7D32;color:#fff;border-radius:10px;">
        💾 {{ isset($article) ? 'Mettre à jour' : 'Créer l\'article' }}
      </button>
      <a href="{{ route('blog.admin.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;">Annuler</a>
    </div>
  </form>

</div>
</section>
@endsection
