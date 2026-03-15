<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immos', function (Blueprint $table) {
            $table->id();
            $table->string('supercie')->nullable();
            $table->float('montant')->nullable();
            $table->longText('description')->nullable();

            $table->timestamps();
            $table->foreignId('bien_id')->nullable();
            $table->foreignId('type_immo_id');
            $table->foreignId('level_id')->nullable();
            $table->foreignId('fournisseur_id')->nullable();

            $table->foreign('fournisseur_id')->references("id")->on('fournisseurs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bien_id')->references("id")->on('biens')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_immo_id')->references("id")->on('type_biens')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('level_id')->references("id")->on('levels')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('immos');
    }
}
