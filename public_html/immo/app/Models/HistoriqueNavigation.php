<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueNavigation extends Model
{
    protected $table = 'historique_navigation';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $dates = ['created_at'];

    public function annonce() { return $this->belongsTo(Annonce::class); }
    public function user() { return $this->belongsTo(User::class); }
}
