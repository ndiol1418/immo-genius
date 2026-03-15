<?php

namespace App\Events;

use App\Models\Annonce;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Déclenché quand un agent/fournisseur soumet une nouvelle annonce.
 * Broadcasté sur le canal privé admin pour notification temps réel.
 */
class AnnonceSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Annonce $annonce) {}

    /**
     * Canal privé partagé par tous les admins.
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('admin-notifications');
    }

    /**
     * Nom de l'événement côté client (écoute via Echo.private(...).listen('.annonce.submitted', ...)).
     */
    public function broadcastAs(): string
    {
        return 'annonce.submitted';
    }

    public function broadcastWith(): array
    {
        return [
            'annonce_id'   => $this->annonce->id,
            'name'         => $this->annonce->name,
            'adresse'      => $this->annonce->adresse,
            'submitted_at' => $this->annonce->created_at?->toIso8601String(),
            'url_admin'    => url("/admin/annonces/{$this->annonce->id}"),
        ];
    }
}
