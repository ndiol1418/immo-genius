<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsLoyerTable extends Migration
{
    public function up()
    {
        Schema::create('paiements_loyer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrat_id')->constrained('contrats_location')->onDelete('cascade');
            $table->decimal('montant', 12, 2);
            $table->string('mois_concerne'); // format: 2026-03
            $table->date('date_paiement')->nullable();
            $table->enum('statut', ['paye', 'en_attente', 'retard'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements_loyer');
    }
}
