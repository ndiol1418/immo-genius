<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionIdToDepartements extends Migration
{
    public function up()
    {
        Schema::table('departements', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id')->nullable()->after('name');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('departements', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
        });
    }
}
