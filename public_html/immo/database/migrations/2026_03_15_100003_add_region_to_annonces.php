<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionToAnnonces extends Migration
{
    public function up()
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->string('region', 100)->nullable()->after('departement_id');
        });
    }

    public function down()
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropColumn('region');
        });
    }
}
