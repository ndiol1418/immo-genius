<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CollaborateurHasNewProfile
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $name;
    public $plateforme;

    public function __construct(User $user, $name = 'users:update', $plateforme = null)
    {
        $this->user = $user;
        $this->name = $name;
        $this->plateforme = $plateforme;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
