<?php

namespace App\Models;

use App\Scopes\CompteScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produit extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new CompteScope);
    }
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function gamme()
    {
        return $this->belongsTo(Gamme::class);
    }

    public function famille()
    {
        return $this->belongsTo(Famille::class);
    }
    public function sous_famille()
    {
        return $this->belongsTo(SousFamille::class);
    }
    public function en_promo()
    {
        return $this->hasMany(EnPromo::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    public function commande_lignes()
    {
        return $this->hasMany(CommandeLigne::class);
    }

    public function getGammeName()
    {
        $gammeNames = [
            1 => 'Mini',
            2 => 'Medium',
            3 => 'Maxi',
            5 => 'Cafe bonjour',
            6 => 'Sport',
        ];

        return $gammeNames[$this->gamme_id] ?? 'N/A';
    }
    static function createOrUpdate($line)
    {
        $produit = new Produit();
        $produit->codebarre = $line[3] ?? "";
        $produit->code_barre_pcb = $line[4] ?? "";
        $produit->tva = $line[10] ?? 0;
        $produit->tva_vente = $line[13] ?? 0;
        $produit->designation_courte = $line[2] ?? 0;
        $produit->code_interne = $line[0] ?? 0;
        if ($line[11])
            $produit->colisage = $line[11];
        else
            $produit->colisage = 1;
        $pu_ttc = round(preg_replace("/[^0-9]/", "", $line[9]));
        if ($line[12] != '' && $line[13] != '') {
            $produit->prix_vente_ttc = round(preg_replace("/[^0-9]/", "", $line[12]));
            $produit->prix_vente_ht = round(($produit->prix_vente_ttc * 100) / (18 + 100));
        }
        $produit->etat = 1;
        // Fournisseur verification
        $fournisseur = Fournisseur::createIfExist($line);
        // famille verification
        $famille = Famille::createIfExist($line[7]);
        // SousFamille verification
        if (!empty($line[8])) {
            $sousfamille = SousFamille::createIfExist($line[8]);
        }

        $tva = 1 + (utf8_encode($line[10]) / 100);
        $produit->fournisseur_id = $fournisseur->id;
        $produit->famille_id = $famille->id;
        $produit->sous_famille_id = $sousfamille->id;
        $produit->prix_unitaire_ht = round($pu_ttc / $tva, 3);
        $produit->prix_ht = round($line[9] * $produit->colisage);
        $produit->prix_ttc = $pu_ttc * $produit->colisage;
        $produit->tva = utf8_encode($line[10]);
        $produit->tva_vente = utf8_encode($line[13]);

        return $produit->save();
    }

    public function ScopeActif($query){
        return $query->where('statut',1);
    }

    public function commandesByMonth(){
        self::updateTimestamps();
        $date12MonthsAgo = Carbon::now()->subMonths(12);
        $commande_lines = $this->commande_lignes()->whereHas('commande',function($item){
                $item->whereIn('etat',['confirmé','traité']);
            })->whereDate('created_at','>',$date12MonthsAgo)
            ->get();
        $groupsByYears = self::groupByYear($commande_lines);

        return self::groupByYearMonths($groupsByYears)??[];
    }

    public function groupByYear($data){
        return $data->groupBy(function($q){
            return Carbon::createFromDate($q->created_at)->format('Y');//->locale('fr')->isoFormat('YYYY');
        });
    }
    public function groupByYearMonths($data){
        return $data->map(function($item,$key){
            return $item->groupBy(function($q){
                return $q->created_at->format('m');
                // return $q->created_at->locale('fr')->isoFormat('MMMM');
            });
        });
    }

    public function updateTimestamps()
    {
        foreach ($this->commande_lignes as $key => $commande_ligne) {
            if (isset($commande_ligne->commande) && $commande_ligne->commande->created_at!=null) {
                $date = Carbon::createFromDate($commande_ligne->commande->commande_date);
                $commande_ligne->commande->created_at = $date;
                $commande_ligne->created_at = $date;
                $commande_ligne->commande->save();
                $commande_ligne->save();

            }
        }
    }
}
