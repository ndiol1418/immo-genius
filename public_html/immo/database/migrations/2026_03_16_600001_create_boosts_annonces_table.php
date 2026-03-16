<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boosts_annonces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('annonce_id');
            $table->unsignedBigInteger('agent_id');
            $table->enum('type', ['standard', 'premium', 'vedette'])->default('standard');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedInteger('prix_paye')->default(0);
            $table->enum('statut', ['actif', 'expire', 'en_attente'])->default('en_attente');
            $table->timestamps();

            $table->foreign('annonce_id')->references('id')->on('annonces')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boosts_annonces');
    }
};
