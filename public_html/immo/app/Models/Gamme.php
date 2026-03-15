<?php

namespace App\Models;

use App\Scopes\CompteScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Gamme extends Model{

    protected $guarded = ['id'];

    protected static function boot(){
        parent::boot();
        return static::addGlobalScope(new CompteScope);
    }

    public function compte() {
        return $this->belongsTo(Compte::class);
    }
    public function ScopeActif($q){
        return $q->where('status',1);
    }
}
