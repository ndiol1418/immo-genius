<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeBien extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function biens() {
        return $this->hasMany(Bien::class);
    }
    public function ScopeActif($q){
        return $q->where('status',1);
    }
}
