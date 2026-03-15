<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComoditesToAnnonces extends Migration
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
            $table->integer('superficie')->default(0);
            $table->longText('comodites')->nullable();
            $table->boolean('meubles')->default(1)->comment('1: Oui, 0: Non');
            $table->boolean('visite_virtuelle')->default(0)->comment('1: Oui, 0: Non');
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
            $table->dropColumn('superficie');
            $table->dropColumn('comodites');
            $table->dropColumn('meubles');
            $table->dropColumn('visite_virtuelle');
        });
    }
}
