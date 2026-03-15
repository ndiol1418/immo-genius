<?php

namespace App\Http\Controllers;

use App\Models\Avi;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fournisseur_id' => ['required', 'exists:fournisseurs,id'],
            'note'           => ['required', 'integer', 'min:1', 'max:5'],
            'commentaire'    => ['nullable', 'string', 'max:1000'],
            'annonce_id'     => ['nullable', 'exists:annonces,id'],
        ]);

        $userId = auth()->id();
        $fournisseurId = $request->fournisseur_id;

        // Empêche l'agent de se noter lui-même
        $fournisseur = Fournisseur::findOrFail($fournisseurId);
        if ($fournisseur->user_id === $userId) {
            return back()->with('error', 'Vous ne pouvez pas vous noter vous-même.');
        }

        Avi::updateOrCreate(
            ['user_id' => $userId, 'fournisseur_id' => $fournisseurId],
            [
                'note'        => $request->note,
                'commentaire' => $request->commentaire,
                'annonce_id'  => $request->annonce_id,
            ]
        );

        return back()->with('success', 'Votre avis a été enregistré.');
    }
}
