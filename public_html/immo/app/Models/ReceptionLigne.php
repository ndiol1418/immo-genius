<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceptionLigne extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    public function commande_ligne() {
        return $this->belongsTo(CommandeLigne::class);
    }
    public function reception() {
        return $this->belongsTo(Reception::class);
    }
}
