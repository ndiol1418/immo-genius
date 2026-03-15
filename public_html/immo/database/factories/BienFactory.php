<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' =>$this->faker->name() ,
            'type_bien_id'=>1,
            'commune_id'=>$this->faker->numberBetween(1,2),
            'type_id'=>1,
            'montant' => $this->faker->numberBetween(110000,200000),
            'lon'=>$this->faker->longitude(-17.535 ,-11.355),
            'lat'=>$this->faker->latitude(12.305,14.692),
        ];
    }
}
