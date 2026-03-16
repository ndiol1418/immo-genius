<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimationHistorique extends Model
{
    protected $table = 'estimations_historique';

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
