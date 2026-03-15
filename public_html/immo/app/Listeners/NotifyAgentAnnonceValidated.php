<?php

namespace App\Listeners;

use App\Events\AnnonceValidated;
use App\Notifications\AnnonceValidatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Notifie l'agent/fournisseur propriétaire de l'annonce quand elle est validée.
 */
class NotifyAgentAnnonceValidated implements ShouldQueue
{
    public string $queue = 'notifications';

    public function handle(AnnonceValidated $event): void
    {
        $annonce     = $event->annonce->loadMissing('immo.fournisseur.user');
        $fournisseur = $annonce->immo?->fournisseur;

        if ($fournisseur?->user) {
            $fournisseur->user->notify(new AnnonceValidatedNotification($annonce));
        }
    }
}
