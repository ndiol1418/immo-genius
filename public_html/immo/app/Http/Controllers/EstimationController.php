<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Commune;
use App\Models\EstimationHistorique;
use Illuminate\Http\Request;

class EstimationController extends Controller
{
    /**
     * Coefficients de localisation par quartier/commune de Dakar.
     */
    private array $coefficientsQuartier = [
        'plateau'     => 1.40,
        'almadies'    => 1.40,
        'ngor'        => 1.40,
        'mermoz'      => 1.40,
        'fann'        => 1.25,
        'point e'     => 1.25,
        'point-e'     => 1.25,
        'liberté'     => 1.25,
        'liberte'     => 1.25,
        'sacré coeur' => 1.20,
        'sacre coeur' => 1.20,
        'mamelles'    => 1.20,
        'médina'      => 1.10,
        'medina'      => 1.10,
        'hlm'         => 1.10,
        'grand dakar' => 1.10,
        'pikine'      => 0.90,
        'guédiawaye'  => 0.90,
        'guediawaye'  => 0.90,
    ];

    public function index()
    {
        $communes = Commune::actif()->orderBy('name')->get();
        return view('estimation.index', compact('communes'));
    }

    public function estimer(Request $request)
    {
        $request->validate([
            'type_bien'  => ['required', 'string'],
            'surface'    => ['required', 'numeric', 'min:10'],
            'commune_id' => ['nullable', 'exists:communes,id'],
            'chambres'   => ['nullable', 'integer', 'min:0'],
            'etat'       => ['nullable', 'string'],
            'meuble'     => ['nullable', 'string'],
        ]);

        $surface   = (float) $request->surface;
        $communeId = $request->commune_id;
        $typeBien  = $request->type_bien;
        $chambres  = (int) ($request->chambres ?? 0);
        $etat      = $request->etat ?? 'bon';
        $meuble    = $request->meuble ?? 'non_meuble';

        // ── 1. Prix/m² par commune ET type de bien ──────────────────────────
        $commune = $communeId ? Commune::find($communeId) : null;

        // Tentative précise : même commune + même type de bien
        $annonces = Annonce::withoutGlobalScopes()
            ->where('status', 1)->where('surface', '>', 0)->where('prix', '>', 0)
            ->whereHas('type_immo', fn($q) => $q->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($typeBien).'%']))
            ->when($communeId, fn($q) => $q->where('commune_id', $communeId))
            ->get();

        // Fallback 1 : même commune, tous types
        if ($annonces->count() < 3 && $communeId) {
            $annonces = Annonce::withoutGlobalScopes()
                ->where('status', 1)->where('surface', '>', 0)->where('prix', '>', 0)
                ->where('commune_id', $communeId)->get();
        }

        // Fallback 2 : tout le pays, même type
        if ($annonces->count() < 3) {
            $annonces = Annonce::withoutGlobalScopes()
                ->where('status', 1)->where('surface', '>', 0)->where('prix', '>', 0)
                ->whereHas('type_immo', fn($q) => $q->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($typeBien).'%']))
                ->get();
        }

        // Fallback 3 : marché national
        if ($annonces->isEmpty()) {
            $annonces = Annonce::withoutGlobalScopes()
                ->where('status', 1)->where('surface', '>', 0)->where('prix', '>', 0)->get();
        }

        $prixParM2 = $annonces->avg(fn($a) => $a->prix / $a->surface) ?: 300000;

        // ── 2. Coefficient quartier ──────────────────────────────────────────
        $coeffQuartier = 1.0;
        $nomCommune    = strtolower(trim($commune?->name ?? ''));
        foreach ($this->coefficientsQuartier as $mot => $coeff) {
            if ($nomCommune && str_contains($nomCommune, $mot)) {
                $coeffQuartier = $coeff;
                break;
            }
        }

        // ── 3. Coefficient état ──────────────────────────────────────────────
        $coeffEtat = match ($etat) {
            'neuf'      => 1.30,
            'recent'    => 1.10,
            'bon'       => 1.00,
            'a_renover' => 0.75,
            default     => 1.00,
        };

        // ── 4. Coefficient mobilier ──────────────────────────────────────────
        $coeffMeuble = ($meuble === 'meuble') ? 1.15 : 1.00;

        // ── 5. Coefficient chambres ──────────────────────────────────────────
        $coeffChambres = 1 + ($chambres * 0.02);

        // ── 6. Prix calculé ──────────────────────────────────────────────────
        $prixEstime = $prixParM2 * $surface * $coeffQuartier * $coeffEtat * $coeffMeuble * $coeffChambres;

        $prixMin   = round($prixEstime * 0.85 / 1000) * 1000;
        $prixMax   = round($prixEstime * 1.15 / 1000) * 1000;
        $nbAnnonces = $annonces->count();

        // ── 7. Niveau de confiance (seuils : >5 = Élevé, 2-5 = Moyen, <2 = Faible)
        $niveauConfiance      = $nbAnnonces > 5  ? 'Élevé' : ($nbAnnonces >= 2 ? 'Moyen' : 'Faible');
        $confianceCouleur     = $nbAnnonces > 5  ? '#2E7D32' : ($nbAnnonces >= 2 ? '#C49A0C' : '#dc3545');
        $confiancePct         = $nbAnnonces > 5  ? 90 : ($nbAnnonces >= 2 ? 55 : 20);

        $result = [
            'prix_min'       => $prixMin,
            'prix_estime'    => round($prixEstime / 1000) * 1000,
            'prix_max'       => $prixMax,
            'prix_m2'        => round($prixParM2),
            'nb_annonces'    => $nbAnnonces,
            'nombreAnnonces' => $nbAnnonces,
            'commune_name'   => $commune?->name ?? 'Toutes communes',
            'confiance'      => $niveauConfiance,
            'niveauConfiance'=> $niveauConfiance,
            'confiance_color'=> $confianceCouleur,
            'confiance_pct'  => $confiancePct,
        ];

        // ── 8. Détail des coefficients ───────────────────────────────────────
        $result['detail'] = [
            ['label' => 'Prix/m² marché', 'valeur' => number_format($prixParM2, 0, ',', ' ') . ' CFA/m²'],
            ['label' => 'Localisation (' . ($commune?->name ?? 'Hors Dakar') . ')', 'valeur' => ($coeffQuartier >= 1 ? '+' : '') . round(($coeffQuartier - 1) * 100) . '%'],
            ['label' => 'État (' . $etat . ')', 'valeur' => ($coeffEtat >= 1 ? '+' : '') . round(($coeffEtat - 1) * 100) . '%'],
            ['label' => 'Mobilier', 'valeur' => ($coeffMeuble > 1 ? '+15%' : '0%')],
        ];

        // ── 9. 3 annonces les plus similaires ───────────────────────────────
        $similaires = Annonce::withoutGlobalScopes()
            ->with(['images', 'commune'])
            ->where('status', 1)->where('surface', '>', 0)
            ->when($communeId, fn($q) => $q->where('commune_id', $communeId))
            ->whereBetween('prix', [$result['prix_min'] * 0.7, $result['prix_max'] * 1.3])
            ->orderByRaw('ABS(surface - ?) ASC', [$surface])
            ->limit(3)
            ->get();

        // ── 10. Sauvegarde historique ────────────────────────────────────────
        try {
            EstimationHistorique::create([
                'session_id'       => session()->getId(),
                'type_bien'        => $typeBien,
                'surface'          => $surface,
                'commune'          => $commune?->name,
                'commune_id'       => $communeId,
                'chambres'         => $chambres,
                'etat'             => $etat,
                'meuble'           => $meuble,
                'prix_estime'      => $result['prix_estime'],
                'prix_min'         => $result['prix_min'],
                'prix_max'         => $result['prix_max'],
                'niveau_confiance' => $result['confiance'],
                'created_at'       => now(),
            ]);
        } catch (\Exception $e) {
            // Table pas encore migrée : on continue silencieusement
        }

        // ── 11. Compteur hebdomadaire dans la zone ───────────────────────────
        $historiqueCount = 0;
        try {
            $historiqueCount = EstimationHistorique::where('created_at', '>=', now()->startOfWeek())
                ->when($communeId, fn($q) => $q->where('commune_id', $communeId))
                ->count();
        } catch (\Exception $e) {}

        $communes = Commune::actif()->orderBy('name')->get();

        return view('estimation.index', compact(
            'communes',
            'result',
            'similaires',
            'historiqueCount',
            // Variables individuelles accessibles directement dans la vue
            'prixEstime',
            'prixMin',
            'prixMax',
            'niveauConfiance',
            'nbAnnonces'
        ));
    }
}
