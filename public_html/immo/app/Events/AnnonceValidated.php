<?php

namespace App\Events;

use App\Models\Annonce;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Déclenché quand un admin valide une annonce (status → 1).
 * Broadcasté sur le canal privé de l'agent propriétaire de l'annonce.
 */
class AnnonceValidated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Annonce $annonce) {}

    /**
     * Canal privé propre à chaque fournisseur/agent.
     * L'annonce doit avoir immo chargé pour obtenir fournisseur_id.
     */
    public function broadcastOn(): PrivateChannel
    {
        $fournisseurId = $this->annonce->immo?->fournisseur_id ?? 0;

        return new PrivateChannel("agent.{$fournisseurId}");
    }

    public function broadcastAs(): string
    {
        return 'annonce.validated';
    }

    public function broadcastWith(): array
    {
        return [
            'annonce_id' => $this->annonce->id,
            'name'       => $this->annonce->name,
            'adresse'    => $this->annonce->adresse,
            'prix'       => $this->annonce->prix,
            'url'        => url("/annonces/{$this->annonce->slug}"),
        ];
    }
}
