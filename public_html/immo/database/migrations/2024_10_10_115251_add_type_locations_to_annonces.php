<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeLocationsToAnnonces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('annonces', function (Blueprint $table) {
            //
            $table->foreignId('type_location_id')->nullable();

            $table->foreign('type_location_id')->references("id")->on('type_locations')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('immos', function (Blueprint $table) {
            //
            $table->foreignId('type_location_id')->nullable();

            $table->foreign('type_location_id')->references("id")->on('type_locations')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('annonces', function (Blueprint $table) {
            //
        });
    }
}
