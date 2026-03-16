<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::publie();
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }
        $articles  = $query->paginate(9)->appends($request->only('categorie'));
        $categorie = $request->categorie;
        return view('blog.index', compact('articles', 'categorie'));
    }

    public function show($slug)
    {
        $article = Article::publie()->where('slug', $slug)->firstOrFail();
        $article->increment('vues');
        $similaires = Article::publie()
            ->where('categorie', $article->categorie)
            ->where('id', '!=', $article->id)
            ->limit(3)->get();
        return view('blog.show', compact('article', 'similaires'));
    }

    // Admin: list all
    public function adminIndex()
    {
        $articles = Article::latest()->paginate(20);
        return view('blog.admin.index', compact('articles'));
    }

    // Admin: create form
    public function create()
    {
        return view('blog.admin.form');
    }

    // Admin: store
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre'     => 'required|max:255',
            'contenu'   => 'required',
            'extrait'   => 'nullable|max:500',
            'categorie' => 'required|in:actualite,guide,conseil,marche,quartier',
            'statut'    => 'required|in:publie,brouillon',
        ]);
        $data['slug']      = Str::slug($data['titre']) . '-' . time();
        $data['auteur_id'] = auth()->id();

        if ($request->hasFile('image_couverture')) {
            $data['image_couverture'] = $request->file('image_couverture')->store('uploads/articles', 'public');
        }

        Article::create($data);
        return redirect()->route('blog.admin.index')->with('success', 'Article créé avec succès.');
    }

    // Admin: edit form
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('blog.admin.form', compact('article'));
    }

    // Admin: update
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $data = $request->validate([
            'titre'     => 'required|max:255',
            'contenu'   => 'required',
            'extrait'   => 'nullable|max:500',
            'categorie' => 'required|in:actualite,guide,conseil,marche,quartier',
            'statut'    => 'required|in:publie,brouillon',
        ]);
        if ($request->hasFile('image_couverture')) {
            $data['image_couverture'] = $request->file('image_couverture')->store('uploads/articles', 'public');
        }
        $article->update($data);
        return redirect()->route('blog.admin.index')->with('success', 'Article mis à jour.');
    }

    // Admin: toggle statut
    public function toggleStatut($id)
    {
        $article = Article::findOrFail($id);
        $article->statut = $article->statut === 'publie' ? 'brouillon' : 'publie';
        $article->save();
        return back()->with('success', 'Statut mis à jour.');
    }
}
