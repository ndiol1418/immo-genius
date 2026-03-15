<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaiementLoyer extends Model
{
    protected $table = 'paiements_loyer';
    protected $guarded = ['id'];
    protected $casts = ['date_paiement' => 'date'];

    public function contrat() { return $this->belongsTo(ContratLocation::class, 'contrat_id'); }
}
