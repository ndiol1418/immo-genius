<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVirtualTourToAnnoncesTable extends Migration
{
    public function up()
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->enum('visite_virtuelle_type', ['none', 'pannellum', 'matterport'])
                  ->default('none')
                  ->after('visite_virtuelle');
            $table->json('visite_360_images')->nullable()->after('visite_virtuelle_type');
            $table->string('matterport_url')->nullable()->after('visite_360_images');
        });
    }

    public function down()
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropColumn(['visite_virtuelle_type', 'visite_360_images', 'matterport_url']);
        });
    }
}
