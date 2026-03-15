<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;
    protected $guarded = ['id'];



    public function users() {
        return $this->hasMany(User::class)->where('statut',1);
    }

    public function fournisseurs() {
        return $this->hasMany(Fournisseur::class);
    }

    public function produits() {
        return $this->hasMany(Produit::class);
    }

    public function stations() {
        return $this->hasMany(Station::class);
    }

    public function familles() {
        return $this->hasMany(Famille::class);
    }

    public function sous_familles() {
        return $this->hasMany(SousFamille::class);
    }

    public function gammes() {
        return $this->hasMany(Gamme::class);
    }

    public function zones() {
        return $this->hasMany(Gamme::class);
    }

    public function devise() {
        return $this->belongsTo(Devise::class,'devise_id');
    }
    public function commandes() {
        return $this->hasMany(Commande::class)->limit(10);
    }
    public function commandes_traitees() {
        return $this->hasMany(Commande::class)->where('etat','traité')->orderBy('commande_date','ASC');
    }
    public function commandes_confirmees() {
        return $this->hasMany(Commande::class)->where('etat','confirmé');
    }
    public function commandes_validees() {
        return $this->hasMany(Commande::class)->where('etat','validé');
    }
    public function commandes_brouillons() {
        return $this->hasMany(Commande::class)->where('etat','brouillon');
    }
    public function commandes_en_retard() {
        return $this->hasMany(Commande::class);
    }
    public function commandes_annulees() {
        return $this->hasMany(Commande::class)->where('etat','annulé');
    }
    public function commandeMoisEnCours(){
        return $this->getCommandeMois(self::getcurrentYear(),self::getcurrentMonth());
    }
    public function commandeMoisPrecedent(){
        $today = Carbon::create('2018-07-10');
        $today = $today->subMonth();
        return $this->getCommandeMois(self::getpreviousYear(),self::getpreviousMonth());
    }
    public function getCommandeMois($year,$month){
        return $this->commandes_traitees()->whereYear('commande_date',$year)->whereMonth('commande_date',$month)->get();
    }
    public function getCaMoisAttribute($year,$month){
        return $this->getCommandeMois($year,$month)->sum('montant_ht');
    }
    public function getCaMoisEnCoursAttribute(){
        return $this->commandeMoisEnCours()->sum('montant_ht');
    }
    public function getCaMoisPrecedentAttribute(){
        return $this->commandeMoisPrecedent()->sum('montant_ht');
    }
    public function getNbreMoisEnCoursAttribute(){
        return $this->commandeMoisEnCours()->count();
    }
    public function getNbreMoisPrecedentAttribute(){
        return $this->commandeMoisPrecedent()->count();
    }

    public function currentCommandesYear($year=null){
        if ($year) $current_year = $year;
        $groupsByYears = $this->commandes_traitees()->whereYear('commande_date',$current_year??self::getcurrentYear())->get();
        $month = $groupsByYears->groupBy(function($commande){
            $created = Carbon::create($commande->commande_date);
            return $created->format('m');
            // return $date->created_at->locale('fr')->isoFormat('MMMM');
        });
        return $month;
    }
    public function groupByYearMonth(){

        $groupsByYears = $this->commandes_traitees()->whereYear('commande_date',self::getcurrentYear())->get();
        $groupsByYears = $groupsByYears->groupBy(function($commande){
            $created = Carbon::create($commande->commande_date);
            return $created->format('Y');
        });
        foreach($groupsByYears as $key => $group){

            $month = $group->groupBy(function($commande){
                $created = Carbon::create($commande->commande_date);
                return $created->format('m');
                // return $date->created_at->locale('fr')->isoFormat('MMMM');
            });

            $groupsByYears[$key] = $month;
        }

        return $groupsByYears;
    }

    static function getcurrentYear(){
        $today = Carbon::now();
        return env('CURRENT_YEAR')??$today->year;
    }
    static function getcurrentMonth(){
        $today = Carbon::now();
        return env('CURRENT_MONTH')??$today->month;
    }
    static function getpreviousMonth(){
        $today = Carbon::now();
        return (env('PREVIOUS_MONTH'))??$today->subMonth()->format('m');
    }
    static function getpreviousYear(){
        $today = Carbon::now();
        if ((int)self::getcurrentMonth() == 1) return env('CURRENT_YEAR')??$today->subYear()->format('Y');

        return env('CURRENT_YEAR')??$today->subYear()->format('Y');
    }
    static function getcurrentDate(){
        $today = Carbon::now();
        return env('CURRENT_DATE')??$today->format('Y-m-d');
    }

    static function arrayMoisEnCours($compte,$today,$current_year=null,$commandes_validees,$commandes_confirmees,$commandes_traitees,$commandes_brouillons,$commandes_annulees,$col=null){
        return
            [
                [
                    'title'=>'Validées',
                    'nbre'=>$commandes_validees,
                    'icon'=>'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                    'col'=>$col??'col-6 col-lg-4 col-sm-6',
                    'subtitle'=>'En attente de confirmation',
                    'modelNbre'=>true
                ],
                [
                    'title'=>'Confirmées',
                    'nbre'=>$commandes_confirmees,
                    'icon'=>'<iconify-icon icon="dashicons:admin-users" width="24" height="24"></iconify-icon>',
                    'col'=>$col??'col-6 col-lg-4 col-sm-6',
                    'subtitle'=>'En attente de livraison',
                    'modelNbre'=>true
                ],
                [
                    'title'=>'Traitées',
                    'nbre'=>$commandes_traitees,
                    'icon'=>'<iconify-icon icon="grommet-icons:shop" width="24" height="24"></iconify-icon>',
                    'col'=>$col??'col-6 col-lg-4 col-sm-6',
                    'subtitle'=>''
                ],
                // [
                //     'title'=>'Brouillons',
                //     'nbre'=>$commandes_brouillons,
                //     'icon'=>'<iconify-icon icon="clarity:users-line" width="24" height="24"></iconify-icon>',
                //     'col'=>$col??'col-6 col-lg-4 col-sm-6',
                // ],
                // [
                //     'title'=>'Annulées',
                //     'nbre'=>$commandes_annulees,
                //     'icon'=>'<iconify-icon icon="clarity:users-line" width="24" height="24"></iconify-icon>',
                //     'col'=>$col??'col-6 col-lg-4 col-sm-6',
                // ],
                [
                    'title'=>'CA HT',
                    'nbre'=>isset($current_year)?$compte->getCommandeMois($today->year,$today->month)->sum('montant_ht'):$compte->ca_mois_en_cours,
                    'icon'=>'<iconify-icon icon="clarity:users-line" width="24" height="24"></iconify-icon>',
                    'col'=>$col??'col-6 col-lg-4 col-sm-6',
                    'param'=>$compte->devise->libelle
                ],
            ];
    }
    static function arrayMoisPrecedent($compte,$current_year=null,$date,$mois_precedent,$commandes_annulees_mois_precedent,$col=null){
        $ca_precedent   =   isset($current_year) && $current_year!=null?$compte->getCommandeMois($date->year,$mois_precedent)->sum('montant_ht'):$compte->ca_mois_precedent;
        $ca_en_cours    =   isset($current_year)?$compte->getCommandeMois($date->year,$date->month)->sum('montant_ht'):$compte->ca_mois_en_cours;
        if ($mois_precedent == (int)$mois_precedent) {
            $_date          =   Carbon::create($current_year)->addYear();
            $ca_en_cours    =   isset($current_year)?$compte->getCommandeMois($_date->year,$_date->month)->sum('montant_ht'):$compte->ca_mois_en_cours;
        }
        return
            [
                [
                    'title'=>'CA HT',
                    'nbre'=>$ca_precedent,
                    'icon'=>'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                    'col'=>$col??'col-6 col-lg-6 col-sm-6',
                    'param'=>$compte->devise->libelle
                ],
                [
                    'title'=>'Traitées',
                    'nbre'=>isset($current_year) && $current_year!=null?$compte->getCommandeMois($date->year,$mois_precedent)->count():$compte->nbre_mois_precedent,
                    'icon'=>'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                    'col'=>$col??'col-6 col-lg-6 col-sm-6',
                ],
                // [
                //     'title'=>'Annulées',
                //     'nbre'=>$commandes_annulees_mois_precedent,
                //     'icon'=>'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                //     'col'=>$col??'col-6 col-lg-6 col-sm-6',
                // ],
                [
                    'title'=>'Taux de croissance',
                    'nbre'=>-(($ca_en_cours - $ca_precedent)*100)/($ca_precedent==0?1:$ca_precedent),
                    'icon'=>'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                    'col'=>$col??'col-6 col-lg-6 col-sm-6',
                    'param'=>'%'
                ]
            ];
    }
    static function arrayStatDashboard($compte){
        return [
            [
                'title'=>'Produits',
                'nbre'=>$compte->produits->count(),
                'icon'=>'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
                'col'=>$col??'col-12 col-lg-3 col-sm-3',
                'modelNbre'=>true,
            ],
            [
                'title'=>'Fournisseurs',
                'nbre'=>$compte->fournisseurs->count(),
                'icon'=>'<iconify-icon icon="dashicons:admin-users" width="24" height="24"></iconify-icon>',
                'col'=>$col??'col-12 col-lg-3 col-sm-3',
                'modelNbre'=>true,
            ],
            [
                'title'=>'Boutiques',
                'nbre'=>$compte->stations->count(),
                'icon'=>'<iconify-icon icon="grommet-icons:shop" width="24" height="24"></iconify-icon>',
                'col'=>$col??'col-12 col-lg-3 col-sm-3',
                'modelNbre'=>true,
                'route'=>'superviseurs.boutiques',
                'key'=>$compte->id
            ],
            [
                'title'=>'Validations',
                'nbre'=>$compte->commandes()->enAttentes()->count(),
                'icon'=>'<iconify-icon icon="grommet-icons:shop" width="24" height="24"></iconify-icon>',
                'col'=>'col-6 col-sm-3 col-lg-3',
                'route'=>'commandes.en_attente',
                'modelNbre'=>true,
                'route'=>'superviseurs.boutiques',
                'subtitle'=>'en attente'
            ]
            // [
            //     'title'=>'Utilisateurs',
            //     'nbre'=>$compte->users->count(),
            //     'icon'=>'<iconify-icon icon="clarity:users-line" width="24" height="24"></iconify-icon>',
            //     'col'=>$col??'col-6 col-lg-3 col-sm-6',
            // ],
        ];
    }

    public function getAsValidationCommandeAttribute(){
        if($this->validation_manager) return true;
        return false;
    }

    static function newCompte(){
        $new_compte = new Compte();
        $new_compte->libelle = 'TEMS';
        $new_compte->email = 'tems@admin.com';
        $new_compte->adresse = 'Almadies';
        if($new_compte->save()){
            $user = new User();
            $user->email = $new_compte->email;
            $user->profil = 'admin';
            $user->compte_id = $new_compte->id;
            $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
            $user->save();
            return $new_compte;
        }
        return false;
    }
}
