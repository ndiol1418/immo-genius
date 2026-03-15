<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GammeStation extends Model
{
    use HasFactory;
    public function gamme() {
        return $this->belongsTo(Gamme::class);
    }
}
