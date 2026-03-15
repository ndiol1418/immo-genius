<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function roles() {
        return $this->hasMany(Role::class);
    }

    public function getEtatBadgeAttribute(){
        if($this->etat == 1){
            return "<i class='fa fa-check-circle text-success'></i>";
        }
        return "<i class='fa fa-times text-danger'></i>";
    }
}
