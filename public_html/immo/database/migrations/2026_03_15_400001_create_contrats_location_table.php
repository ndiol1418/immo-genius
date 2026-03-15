<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratsLocationTable extends Migration
{
    public function up()
    {
        Schema::create('contrats_location', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained()->onDelete('cascade');
            $table->foreignId('locataire_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->decimal('loyer_mensuel', 12, 2);
            $table->decimal('charges', 12, 2)->default(0);
            $table->decimal('caution', 12, 2)->default(0);
            $table->enum('statut', ['actif', 'expire', 'resilie'])->default('actif');
            $table->text('signature_agent')->nullable();
            $table->text('signature_locataire')->nullable();
            $table->timestamp('date_signature_agent')->nullable();
            $table->timestamp('date_signature_locataire')->nullable();
            $table->boolean('contrat_signe')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contrats_location');
    }
}
