<?php

namespace App\Listeners;

use App\Models\Action;
use App\Events\ActionLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveLogAction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActionLog  $event
     * @return void
     */
    public function handle(ActionLog $event)
    {
        Action::create([
            'type' => $event->type ? $event->type : "Type - manquant",
            'user_id' => $event->user_id,
            'commentaire' => $event->commentaire ? $event->commentaire : "Commentaire - manquant"
        ]);
    }
}
