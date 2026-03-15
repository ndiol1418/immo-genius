<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desserte extends Model
{
    public $guarded = [];
    public $timestamps = false;
    use HasFactory;
    public function zone() {
        return $this->belongsTo(Zone::class);
    }
    public function fournisseur() {
        return $this->belongsTo(Fournisseur::class);
    }
}
