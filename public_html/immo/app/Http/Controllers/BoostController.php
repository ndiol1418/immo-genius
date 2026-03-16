<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\BoostAnnonce;
use App\Models\Fournisseur;
use App\Scopes\AnnonceScope;
use Illuminate\Http\Request;

class BoostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'annonce_id' => ['required', 'exists:annonces,id'],
            'type'       => ['required', 'in:standard,premium,vedette'],
        ]);

        $agent = Fournisseur::where('user_id', auth()->id())->firstOrFail();

        // Vérifier que l'annonce appartient à cet agent
        $annonce = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->where('id', $request->annonce_id)
            ->where('fournisseur_id', $agent->id)
            ->firstOrFail();

        $tarifs = BoostAnnonce::tarifs();
        $tarif  = $tarifs[$request->type];

        // Désactiver les boosts actifs existants sur cette annonce
        BoostAnnonce::where('annonce_id', $annonce->id)->where('statut', 'actif')->update(['statut' => 'expire']);

        BoostAnnonce::create([
            'annonce_id' => $annonce->id,
            'agent_id'   => $agent->id,
            'type'       => $request->type,
            'date_debut' => now()->toDateString(),
            'date_fin'   => now()->addDays($tarif['duree'])->toDateString(),
            'prix_paye'  => $tarif['prix'],
            'statut'     => 'actif',
        ]);

        return back()->with('success', "Annonce boostée en mode {$tarif['label']} pour {$tarif['duree']} jours !");
    }
}
