<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnPromo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    public function getTypePromoAttribute()
    {
        switch ($this->type) {
            case 1:
                return 'Pourcentage';
            case 2:
                return 'Montant';
            case 3:
                return 'Quantité';
            default:
                return 'Inconnu';
        }
    }

    public static function supprimerLigne($id)
    {
        $en_promo = EnPromo::findOrFail($id);
        return $en_promo->delete();
    }

}
