<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoostAnnonce extends Model
{
    protected $table = 'boosts_annonces';
    protected $guarded = ['id'];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function scopeActif($query)
    {
        return $query->where('statut', 'actif')->where('date_fin', '>=', now()->toDateString());
    }

    /** Tarifs par type */
    public static function tarifs(): array
    {
        return [
            'standard' => ['duree' => 7,  'prix' => 5000,  'label' => 'Standard',  'emoji' => '⭐'],
            'premium'  => ['duree' => 15, 'prix' => 10000, 'label' => 'Premium',   'emoji' => '👑'],
            'vedette'  => ['duree' => 30, 'prix' => 20000, 'label' => 'Vedette',   'emoji' => '🔥'],
        ];
    }
}
