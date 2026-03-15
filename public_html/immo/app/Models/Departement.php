<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $guarded = [];

    public function biens() {
        return $this->hasManyThrough(Bien::class,Commune::class);
    }

    public function ScopeActif($q){
        return $q->where('status',1);
    }
    public function posteChefDepart(){
        return $this->belongsTo(Poste::class,'poste_id')->with('collaborateurs');
    }

    public function chefDuDepartement(){
        if($this->posteChefDepart){
            return $this->posteChefDepart->collaborateurs->first();
        }
        return null;
    }

    public function communes() {
        return $this->hasMany(Commune::class);
    }

    public function getEtatBadgeAttribute(){
        return $this->etat == 1 ?
             "<span class='badge badge-success'>Actif</span>" :
             "<span class='badge badge-danger'>Inactif</span>";
    }
}
