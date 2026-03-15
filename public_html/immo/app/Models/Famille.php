<?php

namespace App\Models;

use App\Scopes\CompteScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Famille extends Model
{
    protected $guarded = ['id'];

    protected static function boot(){
        parent::boot();
        return static::addGlobalScope(new CompteScope);
    }

    public function compte() {
        return $this->belongsTo(Compte::class);
    }

    public function SousFamilles() {
        return $this->hasMany(SousFamille::class);
    }

    public function ActifScope($q){
        return $q->where('status',1);
    }
    static function createIfExist($line){
        $user = Auth::user();
        $name = mb_convert_encoding($line, 'UTF-8', 'ISO-8859-1');

        $exist = Famille::where('libelle',$name)->first();
        if ($exist) return $exist;
        $new = new Famille();
        $new->libelle = $name;
        $new->compte_id = $user->compte_id;
        return $new->save()? $new:false;
    }
}
