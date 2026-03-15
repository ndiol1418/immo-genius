<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentIdToImmos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('immos', function (Blueprint $table) {
            //
            $table->foreignId('agent_id')->nullable();

            $table->foreign('agent_id')->references("id")->on('fournisseurs')->onDelete('set null')->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('immos', function (Blueprint $table) {
            //
        });
    }
}
