<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function auteur()
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    public function scopePublie($q)
    {
        return $q->where('statut', 'publie')->orderBy('created_at', 'DESC');
    }

    public function getCategorieLibelleAttribute()
    {
        $labels = [
            'actualite' => 'Actualité',
            'guide'     => 'Guide',
            'conseil'   => 'Conseil',
            'marche'    => 'Marché',
            'quartier'  => 'Quartier',
        ];
        return $labels[$this->categorie] ?? ucfirst($this->categorie);
    }

    public function getCategorieCouleurAttribute()
    {
        $colors = [
            'actualite' => '#0d1c2e',
            'guide'     => '#2E7D32',
            'conseil'   => '#C49A0C',
            'marche'    => '#6366f1',
            'quartier'  => '#dc3545',
        ];
        return $colors[$this->categorie] ?? '#888';
    }

    public function getUrlAttribute()
    {
        return route('blog.show', $this->slug);
    }
}
