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
        Schema::create('builds', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('build_link');
            $table->foreignId('race_id')->constrained();
            $table->string('title');
            $table->integer('ap_nbr');
            $table->integer('mp_nbr');
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_pvp');
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
        Schema::dropIfExists('builds');
    }
};
