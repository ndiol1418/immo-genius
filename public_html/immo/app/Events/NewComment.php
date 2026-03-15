<?php

namespace App\Events;

use App\Models\Commentaire;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Déclenché quand un visiteur poste un commentaire sur le profil d'un agent.
 * Broadcasté sur le canal privé de l'agent ciblé.
 */
class NewComment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Commentaire $commentaire) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("agent.{$this->commentaire->fournisseur_id}");
    }

    public function broadcastAs(): string
    {
        return 'new.comment';
    }

    public function broadcastWith(): array
    {
        return [
            'commentaire_id' => $this->commentaire->id,
            'description'    => mb_substr($this->commentaire->description, 0, 120),
            'posted_at'      => $this->commentaire->created_at?->toIso8601String(),
            'url'            => url("/agent/{$this->commentaire->fournisseur_id}"),
        ];
    }
}
