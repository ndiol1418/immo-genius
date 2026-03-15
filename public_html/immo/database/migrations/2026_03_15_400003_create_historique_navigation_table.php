<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriqueNavigationTable extends Migration
{
    public function up()
    {
        Schema::create('historique_navigation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('session_id', 100)->nullable();
            $table->foreignId('annonce_id')->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('duree_vue')->default(0); // secondes
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historique_navigation');
    }
}
