<?php

namespace App\Models;

use App\Scopes\BienScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new BienScope);
    }


    public function fournisseur() {
        return $this->belongsTo(Fournisseur::class);
    }
    public function commune() {
        return $this->belongsTo(Commune::class);
    }
    public function immos() {
        return $this->hasMany(Immo::class);
    }
    public function type_bien() {
        return $this->belongsTo(TypeBien::class);
    }
    public function type() {
        return $this->belongsTo(Type::class);
    }
    public function ScopeActif($q){
        return $q->where('status',1);
    }
    public function getLatitudeAttribute(){
        return 1;
    }
    public function getLongitudeAttribute(){
        return $this->lon;
    }
}
