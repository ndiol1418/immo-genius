<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Crée les rôles applicatifs si ils n'existent pas encore.
     *
     * Rôles :
     *  - admin      → accès complet (back-office)
     *  - gerant     → gestion des commandes et de son espace
     *  - fournisseur → agent immobilier / espace agent
     *  - agent      → agent commercial
     *  - client     → acquéreur / locataire
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'gerant',
            'fournisseur',
            'agent',
            'client',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role, 'guard_name' => 'web']
            );
        }

        $this->command->info('Rôles Spatie créés : ' . implode(', ', $roles));
    }
}
