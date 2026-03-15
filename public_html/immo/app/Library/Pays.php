<?php

namespace App\Library;
class Pays
{
    const liste = [
        'Sénégal',
        'Guinée Conakry',
        'Ghana',
        "Côte D'Ivoire",
        "Burkina Faso",
        "RD Congo",
        "Tchad",
        "Nigeria",
    ];
    const name = [
        'Couleur',
        'Couleur',
        'Couleur',
        'Couleur',
        'Couleur',
        'Couleur',
        'Couleur',
        'Couleur',
        'Couleur',
        'Couleur',
    ];
    public $code ;

    public function __construct($index)
    {
        $this->code = Self::liste;
        // $this->name = Self::name[$index];
    }

    public static function getListe(){
        return Self::liste;
    }
    public static function getName($index){
        return Self::name[$index];
    }
}
