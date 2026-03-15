<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommuneResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'departement' => $this->whenLoaded(
                'departement',
                fn () => [
                    'id'   => $this->departement->id,
                    'name' => $this->departement->name,
                ]
            ),
        ];
    }
}
