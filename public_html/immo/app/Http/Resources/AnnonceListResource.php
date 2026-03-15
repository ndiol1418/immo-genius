<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Version allégée d'une annonce, utilisée dans les listes paginées.
 * Charge uniquement les champs nécessaires à l'affichage d'une carte.
 */
class AnnonceListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'ref'              => $this->ref,           // accessor: 'A-00{id}'
            'name'             => $this->name,
            'adresse'          => $this->adresse,
            'prix'             => $this->prix,
            'superficie'       => $this->superficie,
            'chambres'         => $this->chambres,
            'toillettes'       => $this->toillettes,
            'meubles'          => (bool) $this->meubles,
            'is_premium'       => (bool) $this->is_premium,
            'is_new'           => $this->is_new,        // accessor: < 7 jours
            'slug'             => $this->slug,
            'lat'              => $this->lat,
            'lon'              => $this->lon,
            'type_location_id' => $this->type_location_id,
            'type_location'    => $this->resolveTypeLocation(),
            'type_immo_id'     => $this->type_immo_id,
            'type_immo'        => $this->whenLoaded(
                'type_immo',
                fn () => new TypeImmoResource($this->type_immo)
            ),
            'commune'          => $this->whenLoaded(
                'commune',
                fn () => new CommuneResource($this->commune)
            ),
            // Première image uniquement (couverture)
            'cover'            => $this->whenLoaded(
                'images',
                fn () => $this->images->isNotEmpty()
                    ? new ImageResource($this->images->first())
                    : null
            ),
            'created_at'       => $this->created_at?->toIso8601String(),
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
