<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnoncePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annonce_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('prix');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreignId('annonce_id')->nullable();

            $table->foreign('annonce_id')->references("id")->on('annonces')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('annonce_prices');
    }
}
