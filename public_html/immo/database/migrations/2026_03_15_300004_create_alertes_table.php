<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertesTable extends Migration
{
    public function up()
    {
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type_bien')->nullable();
            $table->string('type_transaction')->nullable(); // louer / acheter
            $table->string('region')->nullable();
            $table->string('departement')->nullable();
            $table->string('commune')->nullable();
            $table->unsignedInteger('prix_min')->nullable();
            $table->unsignedInteger('prix_max')->nullable();
            $table->unsignedInteger('chambres_min')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('alertes');
    }
}
