<?php

namespace App\Models;

use App\Scopes\CompteScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected static function boot(){
        parent::boot();
        // return static::addGlobalScope(new CompteScope);
    }

    public function stations() {
        return $this->hasMany(Station::class);
    }

    public function compte() {
        return $this->belongsTo(Compte::class);
    }
    public function dessertes(){
        return $this->hasMany(Desserte::class);
    }
    public function ScopeActif ($query) {
        return $query->where('statut',1);
     }
}

