<?php
namespace App\Services;

use App\Models\Annonce;
use App\Models\HistoriqueNavigation;
use App\Scopes\AnnonceScope;
use Illuminate\Support\Facades\DB;

class RecommandationService
{
    /**
     * Retourne 4 annonces recommandées basées sur l'historique de navigation
     * de l'utilisateur connecté ou de la session courante.
     */
    public function recommander(?int $excludeId = null): \Illuminate\Support\Collection
    {
        $userId    = auth()->id();
        $sessionId = session()->getId();

        // Récupère les annonces vues
        $history = HistoriqueNavigation::when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('session_id', $sessionId))
            ->with('annonce')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();

        if ($history->isEmpty()) {
            // Fallback : annonces les plus récentes
            return Annonce::withoutGlobalScope(AnnonceScope::class)
                ->with('images')
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->inRandomOrder()
                ->limit(4)
                ->get();
        }

        // Calcule les préférences
        $annoncesVues    = $history->pluck('annonce')->filter();
        $typeImmoIds     = $annoncesVues->pluck('type_immo_id')->filter()->countBy()->sortDesc()->keys()->take(2);
        $communeIds      = $annoncesVues->pluck('commune_id')->filter()->countBy()->sortDesc()->keys()->take(3);
        $typeLocationId  = $annoncesVues->pluck('type_location_id')->filter()->mode();

        $prixMoy = $annoncesVues->avg('prix') ?: 0;
        $prixMin = $prixMoy * 0.5;
        $prixMax = $prixMoy * 1.5;

        $chambresAvg = round($annoncesVues->avg('chambres') ?: 0);

        $vuesIds = $annoncesVues->pluck('id')->toArray();
        if ($excludeId) $vuesIds[] = $excludeId;

        // Requête avec scoring
        $query = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->with('images')
            ->whereNotIn('id', $vuesIds);

        // Score : type_immo_id matching (priorité max)
        if ($typeImmoIds->isNotEmpty()) {
            $query->orderByRaw('CASE WHEN type_immo_id IN (' . $typeImmoIds->implode(',') . ') THEN 0 ELSE 1 END ASC');
        }

        // Filtre prix dans la fourchette ±50%
        if ($prixMoy > 0) {
            $query->whereBetween('prix', [$prixMin, $prixMax]);
        }

        $result = $query->limit(4)->get();

        // Si pas assez, compléter avec des annonces aléatoires
        if ($result->count() < 4) {
            $complement = Annonce::withoutGlobalScope(AnnonceScope::class)
                ->with('images')
                ->whereNotIn('id', array_merge($vuesIds, $result->pluck('id')->toArray()))
                ->inRandomOrder()
                ->limit(4 - $result->count())
                ->get();
            $result = $result->concat($complement);
        }

        return $result;
    }
}
