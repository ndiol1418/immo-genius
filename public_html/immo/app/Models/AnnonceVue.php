<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnonceVue extends Model
{
    protected $table = 'annonce_vues';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $dates = ['created_at'];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
}
