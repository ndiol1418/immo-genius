<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaborateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborateurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom',100);
            $table->string('prenom',100);
            $table->string('photo', 255)->nullable();
            $table->string('telephone',20)->nullable();
            $table->string('mobile',20)->nullable();
            $table->tinyInteger('genre')->nullable();
            $table->timestamps();
            
            //Foreigns keys
            $table->foreignId('user_id');
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
        Schema::dropIfExists('collaborateurs');
    }
}
