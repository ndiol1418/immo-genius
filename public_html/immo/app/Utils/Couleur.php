<?php

namespace App\Utils;
class Couleur
{
    const liste = [
        '#87CEFA',
        '#4169E1',
        '#FF6347',
        '#7FFF00',
        '#808000',
        '#ADFF2F',
        '#008000',
        '#FF7F50',
        '#CD5C5C',
        '#F08080',
        '#E9967A',
        '#FA8072',
        '#FFA07A',
        '#FF4500',
        '#6B8E23',
        '#FF8C00',
        '#FFA500',
        '#FFD700',
        '#006400',
        '#B8860B',
        '#DAA520',
        '#EEE8AA',
        '#BDB76B',
        '#F0E68C',
        '#FFFF00',
        '#9ACD32',
        '#556B2F',
        '#7CFC00',
        '#7FFF00',
        '#ADFF2F',
        '#006400',
        '#008000',
        '#228B22',
        '#00FF00',
        '#32CD32',
        '#90EE90',
        '#98FB98',
        '#8FBC8F',
        '#00FA9A',
        '#00FF7F',
        '#2E8B57',
        '#66CDAA',
        '#3CB371'
    ];
    public $code ;

    public function __construct($index)
    {
        $this->code = Self::liste[$index];
    }

    public static function get($index){
        return Self::liste[$index];
    }
}
