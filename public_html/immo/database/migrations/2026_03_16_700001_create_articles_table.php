<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('slug')->unique();
            $table->longText('contenu');
            $table->text('extrait')->nullable();
            $table->string('image_couverture')->nullable();
            $table->unsignedBigInteger('auteur_id')->nullable();
            $table->enum('categorie', ['actualite', 'guide', 'conseil', 'marche', 'quartier'])->default('actualite');
            $table->enum('statut', ['publie', 'brouillon'])->default('brouillon');
            $table->integer('vues')->default(0);
            $table->timestamps();
            $table->foreign('auteur_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    public function down() { Schema::dropIfExists('articles'); }
};
