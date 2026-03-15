<?php

namespace App\Notifications;

use App\Models\Annonce;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification envoyée à l'agent/fournisseur quand son annonce est validée.
 */
class AnnonceValidatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Annonce $annonce) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'       => 'annonce_validated',
            'annonce_id' => $this->annonce->id,
            'name'       => $this->annonce->name,
            'message'    => "Votre annonce « {$this->annonce->name} » a été validée et est maintenant en ligne.",
            'url'        => url("/annonces/{$this->annonce->slug}"),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
