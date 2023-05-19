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
        Schema::create('skin_winners', function (Blueprint $table) {
            $table->id();
            $table->integer('skin_id');
            $table->integer('reward_id');
            $table->string('user_name');
            $table->string('image_path');
            $table->integer('weekly_likes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skin_winners');
    }
};
