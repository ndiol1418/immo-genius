<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->longText('description')->nullable();
            $table->longText('adresse')->nullable();
            $table->integer('prix');
            $table->string('lon')->nullable();
            $table->string('lat')->nullable();
            $table->longText('pieces')->nullable();
            $table->timestamps();
            $table->boolean('status')->default(1);
            $table->foreignId('immo_id')->nullable();
            $table->foreignId('commune_id')->nullable();
            $table->foreignId('departement_id')->nullable();

            $table->foreign('immo_id')->references("id")->on('immos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('commune_id')->references("id")->on('communes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('departement_id')->references("id")->on('departements')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('annonces');
    }
}
