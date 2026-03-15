<?php

namespace Database\Factories;

use App\Models\Annonce;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imageDir = public_path('uploads/annonces/');
        $val = $this->faker->image($imageDir, 640, 480, 'Vytimo', false, true, 'Faker Image');
        return [
            //
            'url'=>'uploads/annonces/'.$val.'',
            'imageable_type'=>'App\Models\Annonce',
            // 'imageable_id'=>Annonce::factory(),
        ];
    }
}
