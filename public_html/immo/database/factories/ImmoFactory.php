<?php

namespace Database\Factories;

use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImmoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'commune_id'=>$this->faker->numberBetween(1,2),
            'supercie'=>$this->faker->numberBetween(150,200),
            'type_location_id'=>1,
            'type_immo_id'=>1,
            'montant' => $this->faker->numberBetween(110000,200000),
            'name' =>$this->faker->name() ,
            'level_id'=>1,
            // 'fournisseur_id'=>Fournisseur::factory(),

        ];
    }
}
