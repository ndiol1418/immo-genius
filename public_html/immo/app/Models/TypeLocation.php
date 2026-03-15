<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeLocation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function immos() {
        return $this->hasMany(Immo::class);
    }
    public function ScopeActif($q){
        return $q->where('status',1);
    }
}
