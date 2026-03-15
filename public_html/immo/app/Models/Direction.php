<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $guarded = [];

    public function departements() {
        return $this->hasMany(Departement::class);
    }

    public function poste_directeur(){
        return $this->belongsTo(Poste::class,'poste_id')->with('collaborateurs');
    }

    public function directeur(){
       // dd($this);
        if(!$this->isDirectionGenerale() && $this->poste_directeur){
            return $this->poste_directeur->collaborateurs->first();
        }
        return null;
    }

    public function isDirectionGenerale(){
        return $this->name == "Direction generale";
    }

    public function getEtatBadgeAttribute(){
        if($this->etat == 1){
            return "<span class='badge badge-success'>Actif</span>";
        }
        return "<span class='badge badge-danger'>Inactif</span>";
    }



    public function getImageAttribute() {
        if(isset($this->image)) {
            return env("CENTRALISATION_LINK", "https://total-workspace-sn.com/") . $this->image;
        }
        return null;
    }
}
