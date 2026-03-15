<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $guarded = [];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class)->withoutGlobalScope(\App\Scopes\AnnonceScope::class);
    }

    public function acheteur()
    {
        return $this->belongsTo(User::class, 'acheteur_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function dernierMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function messagesNonLus($userId)
    {
        return $this->messages()->where('sender_id', '!=', $userId)->where('lu', false)->count();
    }
}
