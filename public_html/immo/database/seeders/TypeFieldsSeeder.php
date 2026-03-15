<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_fields')->insertOrIgnore(array(
            array('id' => '1','etat' => 1, 'name' => 'Texte court','type' => 'varchar'),
            array('id' => '2','etat' => 1, 'name' => 'Nombre','type' => 'number'),
            array('id' => '3','etat' => 1, 'name' => 'Liste à choix multiple','type' => 'checkbox'),
            array('id' => '4','etat' => 1, 'name' => 'Liste à choix unique','type' => 'radio'),
            array('id' => '5','etat' => 1, 'name' => 'Liste déroulante','type' => 'select'),
            array('id' => '6','etat' => 1, 'name' => 'Texte long','type' => 'textarea'),
            array('id' => '7','etat' => 1, 'name' => 'Date','type' => 'date'),
            array('id' => '8','etat' => 1, 'name' => 'Grille','type' => 'grille'),
            array('id' => '9','etat' => 1, 'name' => 'Séparateur','type' => 'separator'),
            array('id' => '10','etat' => 1, 'name' => 'Fichier à joindre','type' => 'file'),
            array('id' => '11','etat' => 1, 'name' => 'Liste interne','type' => 'select')
        ));
    }
}
