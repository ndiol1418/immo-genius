<?php

namespace App\Models;

use App\Scopes\AnnonceFrontScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnonceFront extends Annonce
{
    use HasFactory;
    protected $table = 'annonces';
    // protected static function boot(){
    //     parent::boot();
    //     static::addGlobalScope(new AnnonceFrontScope());
    // }
}
