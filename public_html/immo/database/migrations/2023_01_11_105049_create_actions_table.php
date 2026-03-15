<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('type', 255);
            $table->longText('commentaire');
            $table->timestamps();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('type_action_id')->nullable();

            $table->foreign('type_action_id')->references("id")->on('type_actions')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('actions');
    }
}
