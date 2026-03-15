<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $guarded = ['id'];
    public function collaborateur()
    {
        return $this->belongsTo(Collaborateur::class);
    }
    public function field()
    {
        return $this->belongsTo(Field::class);
    }


    public function getValueTexteAttribute()
    {
        $field = $this->field;
        $field->info = $this;
        return view("partials.components.infoTexte", compact("field"));
    }
}
