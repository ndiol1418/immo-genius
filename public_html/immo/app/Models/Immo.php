<?php

namespace App\Models;

use App\Scopes\BienScope;
use App\Scopes\ImmoScope;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ImmoScope);
    }
    protected $casts = [
        'pieces' => AsArrayObject::class,
    ];
    public function annonce() {
        return $this->hasOne(Annonce::class);
    }
    public function fournisseur() {
        return $this->belongsTo(Fournisseur::class);
    }
    public function type_location() {
        return $this->belongsTo(TypeLocation::class);
    }
    public function level() {
        return $this->belongsTo(Level::class);
    }
    public function agent() {
        return $this->belongsTo(Fournisseur::class,'agent_id');
    }
    public function bien() {
        return $this->belongsTo(Bien::class)->withoutGlobalScope(BienScope::class);
    }
    public function commune() {
        return $this->belongsTo(Commune::class);
    }
    // public function commune() {
    //     return $this->bien->commune;
    // }
    public function ScopeActif($q){
        return $q->where('status',1);
    }
}
