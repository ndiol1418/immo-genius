<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
Use App\Models\Poste;
use App\Scopes\CompteScope;

class Collaborateur extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    static function actif(){
        $collaborateurs = self::orderBy('prenom','ASC')->get();
        return $collaborateurs->filter(function($collaborateur){
            return $collaborateur->user->etat;
        });
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function direction() {
        return $this->belongsTo(Direction::class);
    }

    public function departement() {
        return $this->belongsTo(Departement::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function poste() {
        return $this->belongsTo(Poste::class);
    }

    public function manager1() {
        return $this->belongsTo(Collaborateur::class, 'n1');
    }

    public function manager2() {
        return $this->belongsTo(Collaborateur::class, 'n2');
    }
    public function manager3() {
        return $this->belongsTo(Collaborateur::class, 'n3');
    }

    public function getArrayManagersAttribute() {

        return $this->getManagers();
    }

    public function getNomCompletAttribute() {
        return $this->prenom .' ' . $this->nom;
    }

    public function getHasManagersAttribute() {
        return ($this->manager1 && $this->manager2 && $this->manager3);
    }

    public function getN1Attribute($value) {
        $managers = $this->getManagers();
        return $managers[0]->id ?? null;
    }
    public function getN2Attribute() {
        $managers = $this->getManagers();
        return $managers[1]->id ?? null;
    }

    public function getN3Attribute(){
        $managers = $this->getManagers();
        return $managers[2]->id ?? null;
    }

    static function getDg(){
        $poste = Poste::where('name',"Directeur Général")->first();
        if($poste){
            return $poste->collaborateurs->first();
        }
        return null;
    }

    public function getManagers(){
        $dg = Self::getDg();
        if (isset($dg) && ($this->id == $dg->id)){
            return [];
        }
        $managers = [];

        if($this->service && $this->service->chefDeService() && $this->service->chefDeService()->id != $this->id){
            $managers[] = $this->service->chefDeService();
        }
        if($this->departement && $this->departement->chefDuDepartement() && $this->departement->chefDuDepartement()->id != $this->id){
            $managers[] = $this->departement->chefDuDepartement();
        }
        if($this->direction && $this->direction->directeur() && $this->direction->directeur()->id != $this->id){
            $managers[] = $this->direction->directeur();
        }
        if($dg && ( $this->isDirecteur() || $this->estDeLaDG() )){
            $managers[] = $dg;
        }
        return $managers;
    }

    public function isDirecteur(){
        return $this->direction->directeur()->id == $this->id;
    }

    public function estDeLaDG(){
        return $this->direction->isDirectionGenerale();
    }



    public function getDirectionNameAttribute(){
        if(isset($this->direction)){
            if($this->direction->name == "Direction générale"){
                return "DG";
            }elseif($this->direction->name == "Direction Financière"){
                return "DFI";
            }elseif($this->direction->name == "Direction des Ressources Humaines"){
                return "DRH";
            }elseif($this->direction->name == "Direction Commerciale Réseau"){
                return "DCR";
            }elseif($this->direction->name == "Direction Clientèle Professionnelle"){
                return "DCP";
            }elseif($this->direction->id == "Direction Exploitation"){
                return "DEX";
            }elseif($this->direction->id == "Direction commerciale Lubrifiant"){
                return "DCL";
            }elseif($this->direction->id == "Direction Contrôle interne et Gouvernance"){
                return "DCIG";
            }elseif($this->direction->id == "Direction Technique"){
                return "DTE";
            }
        }else return "";

    }



}
