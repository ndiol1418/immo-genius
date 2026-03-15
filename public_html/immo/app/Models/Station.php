<?php

namespace App\Models;

use App\Scopes\CompteScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Station extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new CompteScope);
    }

    public $typeSeries = ['AC','AV','CD','DR','FC','FR','FT','FV','MBC'];

    public function zone() {
        return $this->belongsTo(Zone::class);
    }
    public function ScopeActif($q){
        return $q->where('status',1);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function gamme_stations() {
        return $this->hasMany(GammeStation::class);
    }
    public function gammes() {
        return $this->gamme_stations()->pluck('gamme_id');
    }

    public function gamme() {
        return $this->belongsTo(Gamme::class);
    }

    public function getisAlcoolAttribute(){
        $class = 'badge-danger';
        $reponse = 'Non';
        if($this->alcool == 1){
            $reponse = 'Oui';
            $class = 'badge-success';
        }
        return '<span class="badge '.$class.'">'.$reponse.'</span>';
    }

    public function serie($val){
        return in_array($val,$this->typeSeries)?$val.$this->numero:'';
    }

    public function getviewGammesAttribute(){
        $gammes = $this->gamme_stations();
        $span = '';
        foreach ($gammes->get() as $key => $value) {
            # code...
            $span.='<span class="badge badge-success mr-2">'.$value->gamme->nom.'</span>';
        }

        return $span;
    }
    public function commandes() {
        return $this->hasMany(Commande::class);
    }
    public function compte() {
        return $this->belongsTo(Compte::class);
    }
    public function getCommandeCurrentMonth(){
        $today = Carbon::now();
        $month  =  $today->month;
        if(request()->has('debut') && request()->has('fin')) {
            $debut = Carbon::createFromFormat('Y-m', request('debut'));
            $fin = Carbon::createFromFormat('Y-m', request('fin'));
            $commandes = Commande::confirmeOrTraites()->where('station_id',$this->id)->get();
            return $commandes->filter(function($item) use ($debut, $fin) {
                $debut = $debut->firstOfMonth();
                $fin = $fin->lastOfMonth();
                return Carbon::parse($item->commande_date)->isBetween($debut->format('Y-m-d'),$fin->format('Y-m-d'));
            });
        }
        return $this->commandes()->confirmeOrTraites()->whereYear('commande_date',$today->year)->whereMonth('commande_date',$month)->get();

    }
    public function royalties(){
        $res['commandes'] = count(self::getCommandeCurrentMonth());
        $res['taux']  =   self::getCommandeCurrentMonth()->sum(function($q){
            return ($q->taux_royalties??($q->fournisseur->taux_royalties??1))*$q->montant_ht;
        });
        return $res;
    }
    public function ca_royalties(){
        $taux = self::royalties()['taux'];
        return number_format($taux/100,2,',', ' ');
    }
    public function getCaCurrentMonth(){
        return number_format(Utils::getCaMoisEnCours($this),0,'',' ');
    }

    public function getdeploiementAttribute(){
        $label = 'leo 2';
        $class = 'badge-success';
        if ($this->plateforme) {
            $label = 'Oasis';
            $class = 'badge-danger';
        }
        return '<span class="badge '.$class.'">'.$label??''.'</span>';
    }
}
