<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Commune;
use Illuminate\Http\Request;

class EstimationController extends Controller
{
    public function index()
    {
        $communes = Commune::actif()->orderBy('name')->get();
        return view('estimation.index', compact('communes'));
    }

    public function estimer(Request $request)
    {
        $request->validate([
            'type_bien'    => ['required', 'string'],
            'surface'      => ['required', 'numeric', 'min:10'],
            'commune_id'   => ['nullable', 'exists:communes,id'],
            'chambres'     => ['nullable', 'integer', 'min:0'],
            'etat'         => ['nullable', 'string'],
        ]);

        $surface     = (float) $request->surface;
        $communeId   = $request->commune_id;
        $typeBien    = $request->type_bien;
        $chambres    = (int) ($request->chambres ?? 0);
        $etat        = $request->etat ?? 'bon';

        // Cherche les annonces similaires pour calculer le prix/m²
        $query = Annonce::withoutGlobalScopes()
            ->where('status', 1)
            ->where('surface', '>', 0)
            ->where('prix', '>', 0);

        if ($communeId) {
            $query->where('commune_id', $communeId);
        }

        $annonces = $query->get();

        if ($annonces->isEmpty()) {
            // Fallback national
            $annonces = Annonce::withoutGlobalScopes()
                ->where('status', 1)
                ->where('surface', '>', 0)
                ->where('prix', '>', 0)
                ->get();
        }

        $prixParM2 = $annonces->avg(fn($a) => $a->prix / $a->surface);
        $prixParM2 = $prixParM2 ?: 300000; // fallback 300k CFA/m²

        // Coefficient état
        $coeffEtat = match($etat) {
            'neuf'       => 1.20,
            'recent'     => 1.10,
            'bon'        => 1.00,
            'a_renover'  => 0.80,
            default      => 1.00,
        };

        // Coefficient chambres (bonus par chambre supplémentaire)
        $coeffChambres = 1 + ($chambres * 0.03);

        $prixEstime = $prixParM2 * $surface * $coeffEtat * $coeffChambres;

        $result = [
            'prix_min'    => round($prixEstime * 0.85 / 1000) * 1000,
            'prix_estime' => round($prixEstime / 1000) * 1000,
            'prix_max'    => round($prixEstime * 1.15 / 1000) * 1000,
            'prix_m2'     => round($prixParM2),
            'nb_annonces' => $annonces->count(),
        ];

        // Annonces similaires
        $similaires = Annonce::withoutGlobalScopes()
            ->with(['immo', 'images', 'commune'])
            ->where('status', 1)
            ->where('surface', '>', 0)
            ->when($communeId, fn($q) => $q->where('commune_id', $communeId))
            ->whereBetween('prix', [$result['prix_min'] * 0.7, $result['prix_max'] * 1.3])
            ->limit(3)
            ->get();

        $communes = Commune::actif()->orderBy('name')->get();

        return view('estimation.index', compact('communes', 'result', 'similaires'))->with('request', $request);
    }
}
