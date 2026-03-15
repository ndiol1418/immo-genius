<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('montant');
            $table->longText('description')->nullable();

            $table->timestamps();
            $table->foreignId('user_id');
            $table->foreignId('charge_id');
            $table->boolean('status')->default(1);

            //Foreigns Keys
            $table->foreignId('reglement_id')->nullable();
            $table->foreign('reglement_id')->references("id")->on('reglements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('charge_id')->references("id")->on('charges')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references("id")->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depenses');
    }
}
