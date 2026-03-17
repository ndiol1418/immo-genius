<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeImmoSeeder extends Seeder
{
    public function run()
    {
        // Types de biens immobiliers
        $types = [
            'Villa',
            'Appartement',
            'Maison',
            'Terrain',
            'Bureau',
            'Local commercial',
            'Immeuble',
            'Studio',
            'Duplex',
            'Entrepôt',
        ];

        foreach ($types as $name) {
            DB::table('type_immos')->insertOrIgnore([
                'name'       => $name,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Types de transaction (Vente / Location)
        $typeLocations = [
            ['name' => 'À Vendre',   'status' => 1],
            ['name' => 'À Louer',    'status' => 1],
            ['name' => 'En Viager',  'status' => 1],
        ];

        foreach ($typeLocations as $tl) {
            DB::table('type_locations')->insertOrIgnore([
                'name'       => $tl['name'],
                'status'     => $tl['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Commodités / Équipements
        $comodites = [
            'Climatisation',
            'Groupe électrogène',
            'Gardiennage 24h/24',
            'Parking couvert',
            'Piscine',
            'Terrasse',
            'Cuisine équipée',
            'Fibre optique',
            'Système d\'alarme',
            'Ascenseur',
            'Balcon',
            'Digicode / Interphone',
            'Eau chaude',
            'Panneau solaire',
            'Jardin',
            'Cave / Débarras',
            'Vidéosurveillance',
        ];

        foreach ($comodites as $name) {
            DB::table('table_comodites')->insertOrIgnore([
                'name'       => $name,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
