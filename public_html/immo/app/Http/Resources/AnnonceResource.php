<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Représentation complète d'une annonce pour la vue détail.
 */
class AnnonceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                 => $this->id,
            'ref'                => $this->ref,
            'name'               => $this->name,
            'description'        => $this->description,
            'adresse'            => $this->adresse,
            'prix'               => $this->prix,
            'superficie'         => $this->superficie,
            'chambres'           => $this->chambres,
            'toillettes'         => $this->toillettes,
            'salons'             => $this->salons,
            'cuisines'           => $this->cuisines,
            'meubles'            => (bool) $this->meubles,
            'is_premium'         => (bool) $this->is_premium,
            'is_new'             => $this->is_new,
            'slug'               => $this->slug,
            'lat'                => $this->lat,
            'lon'                => $this->lon,
            'url_video'          => $this->url_video,
            'visite_virtuelle'   => $this->visite_virtuelle,
            'date_disponibilite' => $this->date_disponibilite,
            'type_location_id'   => $this->type_location_id,
            'type_location'      => $this->resolveTypeLocation(),
            'type_immo_id'       => $this->type_immo_id,
            'type_immo'          => $this->whenLoaded(
                'type_immo',
                fn () => new TypeImmoResource($this->type_immo)
            ),
            'commune'            => $this->whenLoaded(
                'commune',
                fn () => new CommuneResource($this->commune)
            ),
            'images'             => $this->whenLoaded(
                'images',
                fn () => ImageResource::collection($this->images)
            ),
            // Agent/fournisseur associé via l'immo
            'agent'              => $this->whenLoaded(
                'immo',
                fn () => $this->immo?->fournisseur
                    ? new AgentListResource($this->immo->fournisseur)
                    : null
            ),
            'created_at'         => $this->created_at?->toIso8601String(),
            'updated_at'         => $this->updated_at?->toIso8601String(),
        ];
    }

    private function resolveTypeLocation(): string
    {
        return match ((int) $this->type_location_id) {
            1       => 'vente',
            2       => 'location',
            default => 'inconnu',
        };
    }
}
