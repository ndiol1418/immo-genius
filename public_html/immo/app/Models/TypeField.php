<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeField extends Model{
    protected $guarded = ['id'];

    public function fields() {
        return $this->hasMany(Field::class);
    }
}
