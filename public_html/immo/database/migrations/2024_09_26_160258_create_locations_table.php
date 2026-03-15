<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->date('date_entree')->nullable();
            $table->date('date_sortie')->nullable();
            $table->float('caution')->nullable();
            $table->foreignId('bien_id');
            $table->foreignId('client_id');
            $table->foreignId('type_immo_id');
            $table->foreign('bien_id')->references("id")->on('biens')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('client_id')->references("id")->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_immo_id')->references("id")->on('type_immos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('locations');
    }
}
