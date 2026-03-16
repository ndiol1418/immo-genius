<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recherches_populaires', function (Blueprint $table) {
            $table->id();
            $table->string('terme', 255);
            $table->unsignedInteger('nombre_recherches')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recherches_populaires');
    }
};
