<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Fournisseur;
use App\Models\TypeImmo;
use App\Models\Annonce;
use App\Scopes\AnnonceScope;
use Illuminate\Http\Request;

class AgentMatchController extends Controller
{
    public function index()
    {
        $communes  = Commune::actif()->orderBy('name')->get();
        $typeImmos = TypeImmo::actif()->get();
        return view('agent-match.index', compact('communes', 'typeImmos'));
    }

    public function match(Request $request)
    {
        $request->validate([
            'type_transaction' => ['required', 'string'],
            'type_bien'        => ['nullable', 'string'],
            'commune_id'       => ['nullable', 'exists:communes,id'],
            'budget'           => ['nullable', 'numeric', 'min:0'],
        ]);

        $communeId       = $request->commune_id;
        $typeBien        = $request->type_bien;
        $typeTransaction = $request->type_transaction;

        $agents = Fournisseur::actif()->with(['avis', 'mes_annonces'])->get();

        $ancienneteMax = $agents->max(fn($a) => $a->created_at?->diffInDays(now()) ?? 0) ?: 1;

        $scored = $agents->map(function (Fournisseur $agent) use ($communeId, $typeBien, $ancienneteMax) {
            $score = 0;

            // ── 40 pts : annonces dans la même commune ────────────────────
            if ($communeId) {
                $nbCommune = Annonce::withoutGlobalScope(AnnonceScope::class)
                    ->where('fournisseur_id', $agent->id)
                    ->where('commune_id', $communeId)
                    ->count();
                $score += min(40, $nbCommune * 8);
            } else {
                // Bonus : volume d'annonces global (max 20 pts)
                $nb = $agent->mes_annonces()->count();
                $score += min(20, $nb * 4);
            }

            // ── 30 pts : note moyenne ─────────────────────────────────────
            $note = $agent->noteMoyenne();
            $score += round(($note / 5) * 30);

            // ── 20 pts : nombre d'avis ────────────────────────────────────
            $nbAvis = $agent->avis()->count();
            $score += min(20, $nbAvis * 2);

            // ── 10 pts : ancienneté ───────────────────────────────────────
            $jours  = $agent->created_at?->diffInDays(now()) ?? 0;
            $score += round(($jours / $ancienneteMax) * 10);

            return ['agent' => $agent, 'score' => min($score, 100)];
        });

        $top3 = $scored->sortByDesc('score')->take(3)->values();

        $communes  = Commune::actif()->orderBy('name')->get();
        $typeImmos = TypeImmo::actif()->get();

        return view('agent-match.index', compact(
            'communes', 'typeImmos', 'top3',
            'typeTransaction', 'typeBien', 'communeId'
        ));
    }
}
