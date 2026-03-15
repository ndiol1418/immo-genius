<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEltsToAnnonces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('annonces', function (Blueprint $table) {
            //
            $table->integer('chambres')->nullable();
            $table->integer('toillettes')->nullable();
            $table->integer('salons')->nullable();
            $table->integer('cuisines')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('annonces', function (Blueprint $table) {
            //
            $table->dropColumn('chambres');
            $table->dropColumn('cuisines');
            $table->dropColumn('toillettes');
            $table->dropColumn('salons');
        });
    }
}
