<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Bien;
use App\Models\Fournisseur;
use App\Models\Image;
use App\Models\Immo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([
        //     CollaborateurSeeder::class,
        //     ProfilSeeder::class,
        // ]);
                // \App\Models\User::factory(2)->create();

        User::factory(1)
            ->has(Fournisseur::factory(1)
                ->has(
                    Bien::factory(1)
                        ->has(
                            Immo::factory(2)
                                ->has(Annonce::factory(1)
                                    ->hasImages(1)
                                )
                            )
                )
            )
            ->has(Role::factory(1))
            ->create();
    }
}
