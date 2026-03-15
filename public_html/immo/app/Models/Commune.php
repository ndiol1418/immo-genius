<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;
        public function ScopeActif($q){
        return $q->where('status',1);
    }
    protected $guarded = ['id'];
    public function departement() {
        return $this->belongsTo(Departement::class);
    }
    public function biens() {
        return $this->hasMany(Bien::class);
    }

    public function getNomCompletAttribute(){
        return $this->name.' - '.$this->departement->name;
    }
}
