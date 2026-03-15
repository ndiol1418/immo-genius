<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Profil complet d'un agent immobilier.
 */
class AgentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'nom'            => $this->nom,
            'prenom'         => $this->prenom,
            'nom_complet'    => $this->nom_complet,
            'telephone'      => $this->telephone,
            'adresse'        => $this->adresse,
            'email'          => $this->whenLoaded(
                'user',
                fn () => $this->user?->email
            ),
            'picture'        => $this->picture ? asset($this->picture) : null,
            'bio'            => $this->bio ?? null,
            'is_premium'     => (bool) ($this->is_premium ?? false),
            // Spécialités : eager-loadé via agent_specialisations.specialisation
            'specialisations' => $this->whenLoaded(
                'agent_specialisations',
                fn () => $this->agent_specialisations
                    ->map(fn ($as) => $as->relationLoaded('specialisation') && $as->specialisation
                        ? ['id' => $as->specialisation->id, 'name' => $as->specialisation->name]
                        : null
                    )
                    ->filter()
                    ->values()
            ),
            // Zones de couverture (communes)
            'zones'          => $this->mes_zones()->map(fn ($c) => [
                'id'   => $c->id,
                'name' => $c->name,
            ])->values(),
            // Statistiques
            'stats'          => [
                'total_annonces' => $this->whenLoaded(
                    'annonces',
                    fn () => $this->annonces->count()
                ),
                'annonces_actives' => $this->whenLoaded(
                    'annonces',
                    fn () => $this->annonces->where('status', 1)->count()
                ),
            ],
            // Dernières annonces publiées (6 max)
            'annonces_recentes' => $this->whenLoaded(
                'annonces',
                fn () => AnnonceListResource::collection(
                    $this->annonces
                        ->where('status', 1)
                        ->sortByDesc('created_at')
                        ->take(6)
                        ->values()
                )
            ),
            'created_at'     => $this->created_at?->toIso8601String(),
        ];
    }
}
