<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_factures', function (Blueprint $table) {
            $table->id();
            $table->integer('montant');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreignId('client_id');
            $table->foreignId('immo_id');
            $table->foreign('client_id')->references("id")->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('immo_id')->references("id")->on('immos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('facture_id');
            $table->foreign('facture_id')->references("id")->on('factures')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('reglement_id');
            $table->foreign('reglement_id')->references("id")->on('reglements')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_factures');
    }
}
