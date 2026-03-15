<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UtilitiesController;

class Promotion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function ScopeEnCours($query) {
        $date_du_jour = now();
        return $query->whereDate('fin' ,'>=' ,$date_du_jour);
    }

    public function ScopeTerminees ($query) {
        $date_du_jour = now();
        return $query->whereDate('fin' ,'<' ,$date_du_jour);
    }

    public function en_promos()
    {
        return $this->hasMany(EnPromo::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
    public static function createOrUpdate($id=null, $data_promotion)
    {
        if ($id) {
            $promotion = self::find($id);
            if (!$promotion) {
                return false;
            }
        } else {
            $promotion = new self();
        }

        if (isset($data_promotion['image'])) {
            $promotion->handleImage($data_promotion['image']);
            unset($data_promotion['image']);
        }

        $promotion->fill($data_promotion);
        $promotion->save();

        return $promotion;
    }

    public function handleImage($image)
    {
        $folder = 'promotions';
        $extensions = ['jpg', 'jpeg', 'png']; 
        $randomName = 'promotion'; 
    
        $path = UtilitiesController::uploadFile($image, $folder, $extensions, $randomName);

        if ($path !== false) {
            if ($this->image && $this->image != $path) {
                Storage::delete('public/' . $this->image);
            }
            $this->image = $path;
        }
    }
    
}
