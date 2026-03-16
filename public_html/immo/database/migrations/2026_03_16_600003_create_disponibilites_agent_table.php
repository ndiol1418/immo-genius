<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disponibilites_agent', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->enum('type_rdv', ['visite', 'consultation', 'signature'])->default('visite');
            $table->enum('statut', ['disponible', 'reserve', 'annule'])->default('disponible');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('fournisseurs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disponibilites_agent');
    }
};
