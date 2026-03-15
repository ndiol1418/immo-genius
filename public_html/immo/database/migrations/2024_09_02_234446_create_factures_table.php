<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->unique();
            $table->integer('montant');
            $table->timestamps();
            $table->foreignId('statut_facture_id');
            $table->foreignId('client_id');
            $table->foreign('client_id')->references("id")->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('statut_facture_id')->references("id")->on('statut_factures')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factures');
    }
}
