<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeLigne extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    // public function add($data,$key){
    //     $data['colisage'][$key];
    //     $data['qte'][$key];
    //     $data['tva_vente'][$key];
    //     $data['prix_ht'][$key];
    //     $data['montant_ttc'][$key];

    // }

    public function commande() {
        return $this->belongsTo(Commande::class);
    }

    public function produit() {
        return $this->belongsTo(Produit::class);
    }
    public function reception_lignes() {
        return $this->hasMany(ReceptionLigne::class);
    }
    public function receptions() {

    }
    public function retours() {
        return $this->hasMany(ReceptionLigne::class)->where('reception',function($q){
            $q->is_retour = 1;
        })->where('reception.is_retour',1);
    }
    public function getQuantiteReceptionneeAttribute() {
        $receptions = $this->reception_lignes()->get();
        $receptions =  $receptions->filter(function($reception_line){
            return $reception_line->reception && $reception_line->reception->is_retour == 0;
        });

        return $receptions->sum('qte_recu');
    }
    public function getQuantiteRetourneeAttribute() {
        $receptions = $this->reception_lignes()->get();
        $receptions =  $receptions->filter(function($reception_line){
            return $reception_line->reception && $reception_line->reception->is_retour == 1;
        });

        return $receptions->sum('qte_recu');
    }
    public function getResteAttribute() {
        return $this->getQuantiteReceptionneeAttribute() - $this->getQuantiteRetourneeAttribute();
    }

    public function retrancherQte($qte){
        $this->quantite_rec -= $qte;
        return $this->save();
    }
    public function getQteRestantAttribute(){
        if (count($this->reception_lignes()->get()) <= 1) {
            $qte = count($this->reception_lignes()->get()) == 1 ? floatval($this->quantite - $this->reception_lignes()->sum('qte_recu')) : null;
        }
        if (count($this->reception_lignes()->get()) > 1) {
            return $this->getResteAttribute() == 0 ? $this->quantite : $this->quantite - $this->getResteAttribute();
        }

        if ($qte < 0) return $this->quantite;
        return floatval($qte);
    }

    public function updateQte($commande_id,$produit_id,$qte){
        $ligne = CommandeLigne::where(['commande_id'=>$commande_id,'produit_id'=>$produit_id])->first();
        if($ligne){
            $ligne->quantite = $qte;
            return $ligne->save();
        }
        return false;
    }

    public function supprimer($commande_id){
        $lignes = CommandeLigne::where(['commande_id'=>$commande_id])->get();
        $result = false;
        foreach($lignes as $ligne){
            $result = $ligne->delete();
        }
        return $result;
    }

    public function _getQteFinale(){
        $commande = Commande::find($this->commande_id);
        if($commande->etat == "traité"){
            return $this->quantite_rec;
        }
        return $this->quantite;
    }

    public static function hasPromo($produit_id){
        // $today = date('Y-m-d');
        // $en_promo =  EnPromo::where(['produit_id' => $produit_id, 'Promotions.fin >=' => $today, 'Promotions.debut <=' => $today ])->first();
        // return $en_promo;
        return false;
    }

    public function getMontantHtAttribute(){
        return $this->QteFinale * $this->prix_ht ;
    }

    public function getMontantTtcAttribute(){
        $tva_fournisseur = $this->getTauxTva();
        $m_tva = round($tva_fournisseur*$this->MontantHt,0);
        $montant_ttc = round($m_tva+$this->MontantHt,0);
        return $montant_ttc;
    }

    public  function getMontantTvaAttribute(){
      $montant_tva = round($this->getMontantTtcAttribute() * ($this->getTauxTva()),0);
      return $montant_tva;
    }

    public function getTauxTva(){
        $produit = Produit::find($this->produit_id);
        return $produit->tva_vente/100;
    }

    public function add($data,$key,$produit_id,$commande_id){
        $this->quantite_rec = 0;
        if($produit_id){
            $produit =  Produit::find($produit_id);
            $this->prix_ht = self::getPrixHt($produit);
            $this->tva = ($produit->tva_vente/100) * $this->prix_ht;
            $this->quantite = $data['qte'][$key];
            $this->produit_id = $produit_id;
            $this->commande_id = $commande_id;
            $en_promo = self::hasPromo($produit->id);
            $this->en_promo_id = $en_promo?$en_promo->id:null;
            if($this->save()) {
                if($en_promo && $en_promo->type == 3 ) $this->addOfferts($en_promo);
                return true;
            }
        }
        return false;
    }
    public function addOfferts($en_promo){
        $offert = new CommandeLigne ;
        $coef = (int)($this->quantite/$en_promo->qte_acht);
        $qte_offerte =  $coef * $en_promo->qte_off;
        $offert->offert = 1;
        $offert->quantite = $qte_offerte ;
        $offert->prix_ht = 0;
        $offert->tva = 0;
        $offert->quantite_rec = 0;
        $offert->commentaire = 'Produit(s) offert(s)';
        $offert->commande_id = $this->commande_id;
        $offert->produit_id = $this->produit_id;
        $offert->en_promo_id = $this->en_promo_id;
        return $offert->save();
    }

    public static function getPrixHt($produit){
        $en_promo = self::hasPromo($produit->id);
        if($en_promo){
            if($en_promo->type == 1){
                return $produit->prix_ht * (1 - ($en_promo->reduction / 100));
            }elseif($en_promo->type == 2){
                return $produit->prix_ht - $en_promo->reduction;
            }
        }
        return $produit->prix_ht;
    }
}
