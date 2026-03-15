<?php

namespace App\Models;

use App\Scopes\CommandeScope;
use App\Scopes\CompteScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Commande extends Model
{
    use HasFactory;
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new CompteScope);
        static::addGlobalScope(new CommandeScope);
    }
    public function commande_lignes() {
        return $this->hasMany(CommandeLigne::class);
    }
    public function receptions() {
        return $this->hasMany(Reception::class);
    }
    public function mes_retours() {
        return $this->hasMany(Reception::class)->where('is_retour',1);
    }
    public function mes_receptions() {
        return $this->hasMany(Reception::class)->where('is_retour',0);
    }
    public function commandes_retournees() {
        return $this->hasMany(Reception::class)->where('is_retour',1);
    }
    public function commandes_receptionnees() {
        return $this->hasMany(Reception::class)->where('is_retour',0);
    }
    public function reception_lignes() {
        return $this->hasManyThrough(ReceptionLigne::class,Reception::class)->where('is_retour',0);
    }
    public function retour_lignes() {
        return $this->hasManyThrough(ReceptionLigne::class,Reception::class)->where('is_retour',1);
    }
    public function getResteAttribute(){
        return $this->reception_lignes()->sum('qte_recu') - $this->retour_lignes()->sum('qte_recu') == 0 ? true : false;
    }
    public function getQteRestantAttribute(){
        return $this->reception_lignes()->sum('qte_recu') - $this->retour_lignes()->sum('qte_recu');
    }
    public function fournisseur() {
        return $this->belongsTo(Fournisseur::class);
    }

    public function station() {
        return $this->belongsTo(Station::class);
    }

    public function compte() {
        return $this->belongsTo(Compte::class);
    }

    public function scopeTraite($q){
        return $q->where('etat','traité');
    }

    public function scopeEnAttentes($q){
        return $q->where('etat','en attente');
    }
    public function scopeEncours($q){
        return $q->whereIn('etat',['validé','confirmé'])->orderBy('id','DESC');
    }
    public function scopeEnBrouillons($q){
        return $q->where('etat','brouillon')->orderBy('id','DESC');
    }
    public function scopeValides($q){
        return $q->where('etat','validé')->orderBy('id','DESC');
    }
    public function scopeConfirmes($q){
        return $q->where('etat','confirmé')->orderBy('id','DESC');
    }
    public function scopeConfirmeOrTraites($q){
        return $q->whereIn('etat',['confirmé','traité'])->orderBy('id','DESC');
    }
    public function scopeTraites($q){
        return $q->where('etat','traité')->orderBy('id','DESC');
    }
    public function scopeAnnulees($q){
        return $q->where('etat','annulé')->orderBy('id','DESC');
    }
    public function updateEtat($etat){
        $this->etat = $etat;
        $this->save();
    }
    public function editable(){
        if(in_array($this->etat,['en attente','brouillon'])) return true;
        return false;
    }
    public function estSoumise(){
        if(!in_array($this->etat,['brouillon'])) return true;
        return false;
    }
    public function estValide(){
        if(in_array($this->etat,['validé'])) return true;
        return false;
    }
    public function estConfirme(){
        if(in_array($this->etat,['confirmé'])) return true;
        return false;
    }
    public function estComplete(){
        $commande = $this;
        $qte_commande =  $commande->commande_lignes()->sum('quantite');
        $qte_reception = $this->getQteRestantAttribute();
        if ($qte_commande == $qte_reception){
            $commande->updateEtat('traité');
            return true; // commande completement receptionnee
        }
        return false;
    }
    public function estInComplete(){
        $commande = $this;
        $qte_reception = $this->getQteRestantAttribute();
        if ($qte_reception == 0 && $commande->etat == 'traité'){
            return true; // commande completement receptionnee
        }
        return false;
    }

    public function getRefAttribute(){
        $date = Carbon::createFromDate($this->crea_date);
        return 'C-00'.$this->id.'-S'.$this->station_id.'F'.$this->fournisseur_id.'-'.$date->format('d-Y');
    }
    public function getDateReceptionAttribute(){
        $date = Carbon::createFromDate($this->crea_date);
       return $date->locale('fr')->isoFormat('Do MMMM YYYY');
    }
    public function getDateCreationAttribute(){
        $date = Carbon::createFromDate($this->crea_date);
       return $date->format('d-m-Y');
    }
    public function getTotalTtcAttribute(){
       return number_format($this->montant_ttc,0,'',' ');
    }

    public function receptionnerDefinitivement(){
        $reception = new  Reception();
        $reception->date = now();
        $reception->commande_id = $this->id;
        $reception->compte_id = Auth::user()->compte_id;
        if($reception->save()){
            foreach ($this->commande_lignes as $key => $commande_ligne) {
                $reception_ligne = new ReceptionLigne();
                $reception_ligne->qte_recu = $commande_ligne->quantite;
                $reception_ligne->commande_ligne_id = $commande_ligne->id;
                $reception_ligne->reception_id = $reception->id;
                $reception_ligne->save();
            }
            $this->updateEtat('traité');

            return true;
        }
        return false;

    }

    public function clone(){
        $clone = $this->replicate();
        $clone->push();
        $clone->created_at = Carbon::now();
        $clone->updated_at = Carbon::now();
        $clone->crea_date = now();
        $clone->commande_date = now();
        $clone->etat = 'brouillon';
        if($clone->save()){

            foreach($this->commande_lignes as $commande_ligne)
            {
                $clone_line = $commande_ligne->replicate();
                $clone_line->push();
                $clone_line->updated_at = Carbon::now();
                $clone_line->created_at = Carbon::now();
                $clone_line->commande_id = $clone->id;
                $clone_line->save();
            }
            return true;
        }

        return false;
    }

    public function getCaTauxRoyaltiesAttribute(){
        return number_format((($this->montant_ht*$this->taux_royalties) / $this->montant_ht),0,'',' ');
    }
    public function getMontantTauxRoyaltiesAttribute(){
        return number_format($this->montant_ht*$this->taux_royalties,0,'',' ');
    }

    public function somme(){
        $lines = $this->commande_lignes;
        $somme = 0;
        foreach ($lines as $key => $line) {
            $somme +=$line->produit->prix_ht*$line->quantite;
        }
        return $somme;
    }
}
