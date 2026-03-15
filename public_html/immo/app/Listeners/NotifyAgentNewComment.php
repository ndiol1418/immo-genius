<?php

namespace App\Listeners;

use App\Events\NewComment;
use App\Models\Fournisseur;
use App\Notifications\NewCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Notifie l'agent concerné quand un commentaire est posté sur son profil.
 */
class NotifyAgentNewComment implements ShouldQueue
{
    public string $queue = 'notifications';

    public function handle(NewComment $event): void
    {
        $fournisseur = Fournisseur::with('user')
            ->find($event->commentaire->fournisseur_id);

        if ($fournisseur?->user) {
            $fournisseur->user->notify(new NewCommentNotification($event->commentaire));
        }
    }
}
