<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unity_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unity_skin_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable();
            $table->text('ip_adress')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unity_likes');
    }
};
