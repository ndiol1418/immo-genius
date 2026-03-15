<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Version allégée d'un agent, utilisée dans les listes et comme relation
 * embarquée dans AnnonceResource.
 */
class AgentListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'nom_complet' => $this->nom_complet,
            'telephone'   => $this->telephone,
            'adresse'     => $this->adresse,
            'is_premium'  => (bool) ($this->is_premium ?? false),
            'picture'     => $this->picture ? asset($this->picture) : null,
        ];
    }
}
