<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnnonceFactory extends Factory
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
            'adresse' =>$this->faker->address() ,
            'description' =>$this->faker->text() ,
            'prix' => $this->faker->numberBetween(110000,200000),
            'is_premium' => $this->faker->numberBetween(1,0),
            'slug'=>$this->faker->slug(6),
            'type_location_id'=>rand(1,2),

        ];
    }
}
