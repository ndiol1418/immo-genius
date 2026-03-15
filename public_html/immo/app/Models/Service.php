<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    public function direction() {
        return $this->belongsTo(Direction::class);
    }


    public function posteChefDeService(){
        return $this->belongsTo(Poste::class,'poste_id')->with('collaborateurs');
    }

    public function chefDeService(){
        if($this->posteChefDeService){
            return $this->posteChefDeService->collaborateurs->first();
        }
        return null;
    }

    public function departement() {
        return $this->belongsTo(Departement::class);
    }

    public function getEtatBadgeAttribute(){
        if($this->etat == 1){
            return "<span class='badge badge-success'>Actif</span>";
        }
        return "<span class='badge badge-danger'>Inactif</span>";
    }
}
