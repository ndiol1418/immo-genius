<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('montant');
            $table->string('superficie')->nullable();
            $table->string('adresse')->nullable();
            $table->string('lon')->nullable();
            $table->string('lat')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreignId('commune_id');
            $table->foreignId('type_bien_id');
            $table->foreignId('type_id');
            $table->foreignId('fournisseur_id')->nullable();
            $table->foreignId('proprietaire_id')->nullable();

            $table->foreign('proprietaire_id')->references("id")->on('proprietaires')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fournisseur_id')->references("id")->on('fournisseurs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('commune_id')->references("id")->on('communes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_bien_id')->references("id")->on('type_biens')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_id')->references("id")->on('types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('biens');
    }
}
