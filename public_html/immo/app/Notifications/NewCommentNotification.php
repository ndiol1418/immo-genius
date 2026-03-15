<?php

namespace App\Notifications;

use App\Models\Commentaire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification envoyée à l'agent quand un visiteur poste un commentaire sur son profil.
 */
class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Commentaire $commentaire) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'           => 'new_comment',
            'commentaire_id' => $this->commentaire->id,
            'extrait'        => mb_substr($this->commentaire->description, 0, 100),
            'message'        => 'Vous avez reçu un nouveau commentaire sur votre profil.',
            'url'            => url("/agent/{$this->commentaire->fournisseur_id}"),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
