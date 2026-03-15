<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEltsToFournisseurs extends Migration
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
            $table->boolean('is_agent')->default(0);
            $table->longText('agents')->nullable();
            $table->foreignId('ouwner_id')->nullable();

            $table->foreign('ouwner_id')->references("id")->on('fournisseurs')->onDelete('set null')->onUpdate('set null');
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
            $table->dropColumn('is_agent');
            $table->dropColumn('agents');

        });
    }
}
