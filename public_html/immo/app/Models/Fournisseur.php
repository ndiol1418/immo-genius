<?php

namespace App\Models;

use App\Scopes\FournisseurScope;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Fournisseur extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'agents' => AsArrayObject::class,
        'zones' => AsArrayObject::class,
    ];
    // protected static function boot(){
    //     parent::boot();
    //     static::addGlobalScope(new FournisseurScope);
    // }
    public function commentaires() {
        return $this->hasMany(Commentaire::class);
    }

    public function avis() {
        return $this->hasMany(Avi::class);
    }

    public function noteMoyenne() {
        return round($this->avis()->avg('note') ?? 0, 1);
    }
    public function getNomCompletAttribute() {
        return $this->prenom .' ' . $this->nom;
    }

    public function ScopeActif ($query) {
       return $query->where('status',1);
    }

    public function immos() {
        return $this->hasMany(Immo::class);
    }
    public function biens() {
        return $this->hasMany(Bien::class);
    }
    public function annonces() {
        return $this->hasManyThrough(Annonce::class,Immo::class);
    }
    public function mes_annonces() {
        return $this->hasMany(Annonce::class,'fournisseur_id');
    }
    public function mes_immos() {
        return $this->hasMany(Immo::class,'agent_id');
    }
    public function agent() {
        return $this->belongsTo(Fournisseur::class,'ouwner_id');
    }

    public function mon_reseau(){
        $fournisseurs = Fournisseur::actif()->get();
        return $fournisseurs->filter(function($q){
            $ids = $q->agents?$q->agents->toArray():[];
            return in_array($this->id,$ids);
        });
    }

    public function getPictureAttribute(){
        return $this->user->image?$this->user->image->url:null;
    }
    public function agent_specialisations(){
        return $this->hasMany(AgentSpecialisation::class,'fournisseur_id');
    }
    
    public function mes_zones(){
        return Commune::whereIn('id',$this->zones??[])->get();
    }
}
