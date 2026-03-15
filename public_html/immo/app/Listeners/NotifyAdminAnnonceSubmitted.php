<?php

namespace App\Listeners;

use App\Events\AnnonceSubmitted;
use App\Models\User;
use App\Notifications\AnnonceSubmittedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

/**
 * Envoie une notification (database + broadcast) à tous les admins
 * dès qu'une nouvelle annonce est soumise.
 */
class NotifyAdminAnnonceSubmitted implements ShouldQueue
{
    public string $queue = 'notifications';

    public function handle(AnnonceSubmitted $event): void
    {
        $admins = User::role('admin')->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new AnnonceSubmittedNotification($event->annonce));
        }
    }
}
