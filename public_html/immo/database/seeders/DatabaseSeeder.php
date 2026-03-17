<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            SenegalGeoSeeder::class,    // Régions, Départements, Communes
            TypeImmoSeeder::class,       // Types de biens, Type locations, Commodités
            AgentsSeeder::class,         // 8 agents immobiliers sénégalais
            AnnoncesSeeder::class,       // 30 annonces réalistes du Sénégal
            ArticleSeeder::class,        // 5 articles blog
        ]);
    }
}
