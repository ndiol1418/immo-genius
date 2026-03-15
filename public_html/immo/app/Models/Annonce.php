<?php

namespace App\Models;

use App\Scopes\AnnonceScope;
use App\Scopes\ImmoScope;
use App\Utils\File;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'pieces'               => AsArrayObject::class,
        'comodites'            => AsArrayObject::class,
        'visite_360_images'    => 'array',
    ];
    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function immo() {
        return $this->belongsTo(Immo::class)->withoutGlobalScope(ImmoScope::class);
    }
    public function type_immo() {
        return $this->belongsTo(TypeImmo::class);
    }
    public function commune() {
        return $this->belongsTo(Commune::class);
    }

    public function ScopeActif($q){
        return $q->where('status',1)->orderBy('id','DESC');
    }
    public function ScopeEnAttente($q){
        return $q->where('status',2);
    }
    public function ScopeSupprimes($q){
        return $q->where('status',0);
    }
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new AnnonceScope);
    }
    public function savePJ($files,$model=null){
        if(count($files) == 0) return false;
        foreach ($files as $tmp_piece) {
            // $ext = $tmp_piece['file']->extension();
            $extensions = ['png','jpeg','jpg','gif'];
            $uploadFile = File::uploadFile($tmp_piece,"uploads/annonces", $extensions);
            if($uploadFile) {
                Image::create([
                    'name' => 'image',
                    'url' => $uploadFile,
                    'imageable_id' => $this->id,
                    'imageable_type' => $model??'',
                ]);
            }
        }

        return true;

    }
    public function updatePJ($files, $model = null)
        {
            if (!$files || count($files) === 0) return false;

            $extensions = ['png', 'jpeg', 'jpg', 'gif'];

            foreach ($files as $tmp_piece) {
                // Si c'est une mise à jour, tu peux ajouter ici une suppression des anciennes images si besoin

                $uploadFile = File::uploadFile($tmp_piece, "uploads/annonces", $extensions);

                if ($uploadFile) {
                    Image::create([
                        'name' => 'image',
                        'url' => $uploadFile,
                        'imageable_id' => $this->id,
                        'imageable_type' => $model ?? get_class($this),
                    ]);
                }
            }

            return true;
        }


    public function getrefAttribute(){
        return 'A-00'.$this->id;
    }

    public function getisNewAttribute(){
        return $this->created_at->diffInDays() < 7;
    }

    public function liste_comodites(){
        $comodites = Comodite::whereIn('id',$this->comodites??[])->get();
        return $comodites;
    }
    public function liste_comodites_internes(){
        $comodites = Comodite::whereIn('id',$this->comodites??[])->where('type',1)->get();
        return $comodites;
    }
    public function liste_comodites_externes(){
        $comodites = Comodite::whereIn('id',$this->comodites??[])->where('type',0)->get();
        return $comodites;
    }


}
