<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEltsImmosToTableImmos extends Migration
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
            $table->string('name')->nullable();
        });
        Schema::table('annonces', function (Blueprint $table) {
            //
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
        Schema::table('immos', function (Blueprint $table) {
            //
            $table->dropColumn('name');
        });
        Schema::table('annonces', function (Blueprint $table) {
            //
            $table->dropColumn('name');
        });
    }
}
