<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->json('specialites')->nullable();
            $table->json('zones_intervention')->nullable();
            $table->text('description_pro')->nullable();
            $table->unsignedSmallInteger('experience_annees')->default(0);
            $table->json('certifications')->nullable();
            $table->json('reseaux_sociaux')->nullable();
            $table->enum('disponibilite', ['disponible', 'occupe', 'conge'])->default('disponible');
        });
    }

    public function down(): void
    {
        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->dropColumn(['specialites','zones_intervention','description_pro','experience_annees','certifications','reseaux_sociaux','disponibilite']);
        });
    }
};
