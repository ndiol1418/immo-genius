<?php

namespace App\Models;

use App\Events\MailEvent;
use App\Exports\CommandesExport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class Reception extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function commande() {
        return $this->belongsTo(Commande::class);
    }
    public function reception_lignes() {
        return $this->hasMany(ReceptionLigne::class);
    }
    public function getQuantiteReceptionneeAttribute() {
        $receptions = $this->reception_lignes()->get();
        $receptions =  $receptions->filter(function($reception_line){
            return $reception_line->reception->is_retour == 0;
        });

        return $receptions->sum('qte_recu');
    }
    static function findOrCreate($commande_id,$is_retour){
        $reception = Reception::where('commande_id',$commande_id)->first();
        // if (!$reception || $is_retour == 1) {
            # code...
            $reception = new Reception();
            $reception->commande_id = $commande_id;
            $reception->is_retour = $is_retour;
            $reception->date = now();
            $reception->compte_id = Auth::user()->compte_id;
            $reception->save();
        // }
        return $reception;
    }

    public function saveLines($data){
        $commande = $this->commande;
        $datas = $commande->commande_lignes;
        $fileName = 'RPA-'.$this->id.'.xlsx';
        $subjet = "Réception partielle de la commande";
        $message = "Réception de la commande ".$this->id." ";
        $montant_ht = 0;
        // dd($commande);
        $datas = [];
        foreach ($data['qte'] as $key => $value) {
            if ($value>0) {
                $new = new ReceptionLigne();
                $new->reception_id = $this->id;
                $new->qte_recu = $value;
                $new->commande_ligne_id = $data['commande_line_id'][$key];
                if($new->save()){
                    $montant_ht += ($new->qte_recu*$new->commande_ligne->produit->prix_ht);
                    $datas[] = $new;
                }
            }
        }
        if ($commande->station->plateforme) {
            if (Excel::store(new CommandesExport($this->reception_lignes), $fileName)) {
                # code...
                $attachement = storage_path('app/'.$fileName);
                event(new MailEvent('commande:reception', $commande, $attachement));
            };
        }
        $commande->montant_ht = !isset($data['is_retour']) ? $montant_ht : $commande->montant_ht - $montant_ht;
        if($commande->montant_ht == 0){
            $init = 0;
            foreach ($commande->commande_lignes as $key => $line) {
                $init += $line->montant_ht;
            }
            $commande->montant_ht = $init;
        }
        // if(NotificationOasis::createJsonFile($datas,$fileName)){
        //     NotificationOasis::notifierMail($fileName,$subjet,$message);
        // }
        $commande->save();
        if ($this->estComplete()) {
            $commande->updateEtat('traité');
        }

    }
    public function estComplete(){
        $commande = $this->commande;
        if ($this->reception_lignes()->sum('qte_recu') == $commande->commande_lignes()->sum('quantite')) {
            return true;
        }
        return false;
    }
    public function isRetour(){
        return $this->is_retour ?true:false;
    }
    public function getTypeAttribute(){
        return $this->is_retour == 0 ? '<span class="badge badge-success">reception</span>': '<span class="badge badge-danger">retour</span>';
    }
    public function getResteAttribute(){
        return $this->reception_lignes()->sum('qte_recu') == $this->commande->commande_lignes()->sum('quantite') ? true : false;
    }
    public function getRefAttribute(){
        $date = Carbon::createFromDate($this->date);
        $station_id = $this->commande?$this->commande->station_id:'';
        $fournisseur_id = $this->commande?$this->commande->fournisseur_id:'';
        return 'R-00'.$this->id.'-S'.$station_id.'F'.$fournisseur_id.'-'.$date->format('d-Y');
    }

    public function getDateReceptionAttribute(){
        $date = Carbon::createFromDate($this->date);
       return $date->locale('fr')->isoFormat('Do MMMM YYYY');
    }
}
