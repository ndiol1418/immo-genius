<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActionLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $user_id;
    public $commentaire;
    public function __construct($type_log, $user_id, $commentaire)
    {
        $this->type = $type_log;
        $this->user_id = $user_id;
        $this->commentaire = $commentaire;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
