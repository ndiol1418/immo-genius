<?php

namespace App\Services;

use App\Models\Annonce;
use App\Models\HistoriqueNavigation;
use App\Scopes\AnnonceScope;

class RecommandationService
{
    /**
     * Retourne une collection de tableaux ['annonce', 'score', 'raisons'].
     * Pondération : type=50%, prix=30%, localisation=20%.
     */
    public function recommander(?int $excludeId = null): \Illuminate\Support\Collection
    {
        $userId    = auth()->id();
        $sessionId = session()->getId();

        $history = HistoriqueNavigation::when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('session_id', $sessionId))
            ->with('annonce')
            ->orderByDesc('created_at')
            ->limit(30)
            ->get();

        $vuesIds = $excludeId ? [$excludeId] : [];

        if ($history->isEmpty()) {
            // Fallback : tendances de la semaine
            $annonces = Annonce::withoutGlobalScope(AnnonceScope::class)
                ->with('images')
                ->whereNotIn('id', $vuesIds)
                ->where('created_at', '>=', now()->subWeek())
                ->latest()->limit(4)->get();

            if ($annonces->count() < 4) {
                $ids = array_merge($vuesIds, $annonces->pluck('id')->toArray());
                $annonces = $annonces->concat(
                    Annonce::withoutGlobalScope(AnnonceScope::class)
                        ->with('images')->whereNotIn('id', $ids)->inRandomOrder()->limit(4 - $annonces->count())->get()
                );
            }

            return $annonces->map(fn($a) => ['annonce' => $a, 'score' => 70, 'raisons' => ['Tendances de la semaine']]);
        }

        // Préférences utilisateur
        $annoncesVues = $history->pluck('annonce')->filter();
        $vuesIds      = array_merge($vuesIds, $annoncesVues->pluck('id')->toArray());

        $topTypes    = $annoncesVues->pluck('type_immo_id')->filter()->countBy()->sortDesc()->keys()->take(2)->toArray();
        $prixMoy     = $annoncesVues->avg('prix') ?: 0;
        $prixMin     = $prixMoy * 0.5;
        $prixMax     = $prixMoy * 1.5;
        $topCommunes = $annoncesVues->pluck('commune_id')->filter()->countBy()->sortDesc()->keys()->take(3)->toArray();

        // Candidats
        $candidats = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->with('images')
            ->whereNotIn('id', $vuesIds)
            ->when($prixMoy > 0, fn($q) => $q->whereBetween('prix', [$prixMin, $prixMax]))
            ->limit(20)->get();

        if ($candidats->count() < 4) {
            $ids = array_merge($vuesIds, $candidats->pluck('id')->toArray());
            $candidats = $candidats->concat(
                Annonce::withoutGlobalScope(AnnonceScope::class)
                    ->with('images')->whereNotIn('id', $ids)->inRandomOrder()->limit(8)->get()
            );
        }

        // Scoring
        $scored = $candidats->map(function (Annonce $annonce) use ($topTypes, $topCommunes, $prixMoy, $prixMin, $prixMax) {
            $score = 0; $raisons = [];

            if (in_array($annonce->type_immo_id, $topTypes)) {
                $score += 50; $raisons[] = 'Type de bien correspondant';
            }
            if ($prixMoy > 0 && $annonce->prix >= $prixMin && $annonce->prix <= $prixMax) {
                $score += 30; $raisons[] = 'Dans votre fourchette de prix';
            }
            if (in_array($annonce->commune_id, $topCommunes)) {
                $score += 20; $raisons[] = 'Zone géographique similaire';
            }
            if ($annonce->created_at && $annonce->created_at->gt(now()->subDays(7))) {
                $score += 5; $raisons[] = 'Nouvelle annonce';
            }

            return ['annonce' => $annonce, 'score' => min($score, 99), 'raisons' => $raisons ?: ['Sélection pour vous']];
        });

        return $scored->sortByDesc('score')->take(4)->values();
    }
}
