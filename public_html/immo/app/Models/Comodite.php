<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comodite extends Model
{
    use HasFactory;
    public function getTypeComoditeAttribute(){
        if ($this->type == 1) return 'Intérieures';
        return 'Extérieures';
    }
}
