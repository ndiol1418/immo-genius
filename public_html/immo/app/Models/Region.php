<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $guarded = [];

    public function departements()
    {
        return $this->hasMany(Departement::class);
    }

    public function ScopeActif($q)
    {
        return $q->where('status', 1);
    }
}
