<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeComodites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comodites', function (Blueprint $table) {
            //
            $table->boolean('type')->default(1)->comment('1: interieur 0: exterieur');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comodites', function (Blueprint $table) {
            //
            $table->dropColumn('type');
        });
    }
}
