<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class CollaborateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)
                        ->has(\App\Models\Collaborateur::factory(1),'collaborateur')
                        ->create();
    }
}
