<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommandesExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data)
    {
        $this->receptions = $data;
    }

    public function collection()
    {
        $datas = [];
        $receptions = $this->receptions;
        foreach ($this->receptions as $key => $reception_ligne) {
            # code...
            if($reception_ligne->qte_recu>0){
                $produit = $reception_ligne->commande_ligne->produit;
                if ($receptions[0]->reception->commande->station->plateforme) {
                    # code...
                    $heure = Carbon::now()->format('H');
                    $fournisseur = $receptions[0]->reception->commande->fournisseur;
                    $datas [] = [
                        'Pays'=>$receptions[0]->reception->commande->compte->libelle,
                        'Serie'=>$receptions[0]->reception->commande->station->serie??'AC',
                        'Nom du site'=>$receptions[0]->reception->commande->station->nom,
                        'Code barre'=>$produit->codebarre,
                        'Designation'=>$produit->designation,
                        'Famille'=>$produit->famille?$produit->famille->libelle:'',
                        'Code Sous Famille'=>$produit->sous_famille?$produit->sous_famille->code:'',
                        'PVTTC'=>$produit->prix_ttc,
                        'Nom du Fournisseur'=>$fournisseur->prenom.' '.$fournisseur->nom,
                        'Code Frounisseur'=>$fournisseur->code??'',
                        'N° Livraison'=>$reception_ligne->reception_id,
                        'Date Livraison'=>$receptions[0]->date,
                        'Heure de Livraison'=>$heure,
                        'Reference Article'=>$produit->id,
                        'PCB'=>$produit->colisage,
                        'Quantite'=>$reception_ligne->qte_recu,
                        'Cout PCB'=>$produit->prix_unitaire_ht,
                        'Cout unitaire'=>$produit->prix_unitaire_ht,
                        'Taxe'=>$produit->tva_vente,
                        '% Remise'=>$produit->remise,
                        'Montant Recu'=>$reception_ligne->qte_recu*$produit->prix_unitaire_ht
                    ];
                }else{
                    $datas[]=[
                        $produit->codebarre,
                        $reception_ligne->qte_recu
                    ];
                }
            }
        }
        // dd($datas);
        return collect($datas);
    }
    protected $receptions;


    public function _array(): array
    {
        return [
            [1, 2, 3],
            [4, 5, 6]
        ];
    }
    public function headings(): array
    {
        if($this->receptions[0]->reception->commande->station->plateforme){

            return [
                'Pays','Serie','Nom du site','Code barre','Designation','Sous Famille','Code Sous Famille',
                'PVTTC','Nom du Fournisseur','Code Frounisseur','N° Livraison','Date Livraison','Heure de Livraison',
                'Reference Article','PCB','Quantite','Cout PCB','Cout unitaire','Taxe','% Remise','Montant Recu'
            ];
        }
        return ['Code barre','Quantite'];
    }
}
