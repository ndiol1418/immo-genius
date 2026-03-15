<?php

namespace App\Notifications;

use App\Models\Annonce;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification envoyée aux admins quand une nouvelle annonce est soumise.
 * Canaux : database (persistance) + broadcast (temps réel via Pusher).
 */
class AnnonceSubmittedNotification extends Notification implements ShouldQueue
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
            'type'       => 'annonce_submitted',
            'annonce_id' => $this->annonce->id,
            'name'       => $this->annonce->name,
            'adresse'    => $this->annonce->adresse,
            'message'    => "Nouvelle annonce soumise en attente de validation : « {$this->annonce->name} ».",
            'url'        => url("/admin/annonces/{$this->annonce->id}"),
        ];
    }

    /**
     * Payload broadcasté sur le canal Laravel.Notification.{userId}.
     * Le canal est automatiquement autorisé par la route Broadcast::channel
     * 'App.Models.User.{id}' définie dans routes/channels.php.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
