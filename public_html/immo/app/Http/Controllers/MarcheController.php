<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\TypeImmo;
use App\Models\Commune;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Scopes\AnnonceScope;

class MarcheController extends Controller
{
    public function index()
    {
        // Prix moyen au m² à Dakar
        $prixMoyen = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->where('status', 1)->where('superficie', '>', 0)
            ->avg(DB::raw('prix / superficie'));
        $prixMoyenM2 = $prixMoyen ? round($prixMoyen) : 0;

        // Nombre d'annonces actives par type
        $annoncesParType = TypeImmo::withCount(['annonces' => fn($q) =>
            $q->withoutGlobalScope(AnnonceScope::class)->where('status', 1)
        ])->get();

        // Prix moyen par type de bien
        $prixParType = DB::table('annonces')
            ->join('type_immos', 'annonces.type_immo_id', '=', 'type_immos.id')
            ->where('annonces.status', 1)->where('annonces.prix', '>', 0)
            ->groupBy('type_immos.id', 'type_immos.name')
            ->select('type_immos.name', DB::raw('AVG(annonces.prix) as prix_moyen'), DB::raw('COUNT(*) as nb'))
            ->orderByDesc('prix_moyen')->get();

        // Variation 30 jours
        $countActuel   = Annonce::withoutGlobalScope(AnnonceScope::class)->where('status', 1)->count();
        $countMoisPasse = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->where('status', 1)->where('created_at', '<', now()->subDays(30))->count();
        $variation30j  = $countMoisPasse > 0 ? round(($countActuel - $countMoisPasse) / $countMoisPasse * 100, 1) : 0;

        // Prix par commune (top 20)
        $prixParCommune = DB::table('annonces')
            ->join('communes', 'annonces.commune_id', '=', 'communes.id')
            ->where('annonces.status', 1)->where('annonces.prix', '>', 0)
            ->groupBy('communes.id', 'communes.name')
            ->select('communes.name', DB::raw('AVG(annonces.prix) as prix_moyen'), DB::raw('COUNT(*) as nb_annonces'))
            ->orderByDesc('prix_moyen')->limit(20)->get();

        // Camembert : répartition par type (labels + data)
        $pieLabels = $annoncesParType->pluck('name');
        $pieData   = $annoncesParType->pluck('annonces_count');

        // Barres : prix moyen par type
        $barLabels = $prixParType->pluck('name');
        $barData   = $prixParType->map(fn($r) => round($r->prix_moyen));

        // Ligne : évolution annonces 6 mois
        $ligneData = [];
        $ligneLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $mois = now()->subMonths($i);
            $ligneLabels[] = $mois->translatedFormat('M Y');
            $ligneData[]   = Annonce::withoutGlobalScope(AnnonceScope::class)
                ->where('status', 1)
                ->whereYear('created_at', $mois->year)
                ->whereMonth('created_at', $mois->month)
                ->count();
        }

        // Total annonces actives
        $totalAnnonces = $countActuel;

        return view('marche.index', compact(
            'prixMoyenM2', 'annoncesParType', 'prixParType', 'variation30j',
            'prixParCommune', 'pieLabels', 'pieData', 'barLabels', 'barData',
            'ligneLabels', 'ligneData', 'totalAnnonces'
        ));
    }

    public function pdf()
    {
        // Reuse same data
        $prixMoyenM2 = round(Annonce::withoutGlobalScope(AnnonceScope::class)
            ->where('status', 1)->where('superficie', '>', 0)
            ->avg(DB::raw('prix / superficie')) ?? 0);

        $annoncesParType = TypeImmo::withCount(['annonces' => fn($q) =>
            $q->withoutGlobalScope(AnnonceScope::class)->where('status', 1)
        ])->get();

        $prixParCommune = DB::table('annonces')
            ->join('communes', 'annonces.commune_id', '=', 'communes.id')
            ->where('annonces.status', 1)->where('annonces.prix', '>', 0)
            ->groupBy('communes.id', 'communes.name')
            ->select('communes.name', DB::raw('AVG(annonces.prix) as prix_moyen'), DB::raw('COUNT(*) as nb_annonces'))
            ->orderByDesc('prix_moyen')->limit(20)->get();

        $totalAnnonces = Annonce::withoutGlobalScope(AnnonceScope::class)->where('status', 1)->count();

        $pdf = Pdf::loadView('marche.pdf', compact('prixMoyenM2', 'annoncesParType', 'prixParCommune', 'totalAnnonces'))
            ->setPaper('a4');

        return $pdf->download('rapport-marche-immobilier-' . now()->format('Y-m') . '.pdf');
    }
}
