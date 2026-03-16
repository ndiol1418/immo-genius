<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estimations_historique', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100);
            $table->string('type_bien', 50);
            $table->decimal('surface', 10, 2);
            $table->string('commune', 100)->nullable();
            $table->unsignedBigInteger('commune_id')->nullable();
            $table->integer('chambres')->default(0);
            $table->string('etat', 30)->default('bon');
            $table->string('meuble', 20)->default('non_meuble');
            $table->unsignedBigInteger('prix_estime');
            $table->unsignedBigInteger('prix_min');
            $table->unsignedBigInteger('prix_max');
            $table->string('niveau_confiance', 20)->default('faible');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estimations_historique');
    }
};
