<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisponibiliteAgent extends Model
{
    protected $table = 'disponibilites_agent';
    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];

    public function agent()
    {
        return $this->belongsTo(Fournisseur::class, 'agent_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
