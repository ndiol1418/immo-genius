<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentSpecialisation extends Model
{
    use HasFactory;

    public function specialisation()
    {
        return $this->belongsTo(Specialisation::class);
    }
}
