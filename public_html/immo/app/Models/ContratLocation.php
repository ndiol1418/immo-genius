<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratLocation extends Model
{
    protected $table = 'contrats_location';
    protected $guarded = ['id'];
    protected $casts = ['date_debut' => 'date', 'date_fin' => 'date'];

    public function annonce() { return $this->belongsTo(Annonce::class); }
    public function locataire() { return $this->belongsTo(User::class, 'locataire_id'); }
    public function agent() { return $this->belongsTo(User::class, 'agent_id'); }
    public function paiements() { return $this->hasMany(PaiementLoyer::class, 'contrat_id'); }

    public function paiementDuMois()
    {
        return $this->paiements()->where('mois_concerne', now()->format('Y-m'))->first();
    }

    public function estSigne()
    {
        return $this->contrat_signe;
    }
}
