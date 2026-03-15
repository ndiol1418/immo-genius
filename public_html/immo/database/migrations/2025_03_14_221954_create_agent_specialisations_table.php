<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentSpecialisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_specialisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialisation_id')->nullable();
            $table->foreignId('fournisseur_id')->nullable();

            $table->foreign('fournisseur_id')->references("id")->on('fournisseurs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('specialisation_id')->references("id")->on('specialisations')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_specialisations');
    }
}
