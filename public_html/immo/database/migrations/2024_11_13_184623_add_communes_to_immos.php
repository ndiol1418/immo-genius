<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommunesToImmos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('immos', function (Blueprint $table) {
            //
            $table->foreignId('commune_id')->nullable();
            $table->foreignId('departement_id')->nullable();

            $table->foreign('departement_id')->references("id")->on('departements')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('commune_id')->references("id")->on('communes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('immos', function (Blueprint $table) {
            //
        });
    }
}
