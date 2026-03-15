<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEltsToAgents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fournisseurs', function (Blueprint $table) {
            //
            $table->longText('description')->nullable();
            $table->string('site')->nullable();
            $table->string('experience')->nullable();
            $table->string('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fournisseurs', function (Blueprint $table) {
            //
            $table->dropColumn('description');
            $table->dropColumn('site');
            $table->dropColumn('experience');
            $table->dropColumn('name');
        });
    }
}
