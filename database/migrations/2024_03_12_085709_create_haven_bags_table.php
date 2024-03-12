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
        Schema::create('haven_bags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('haven_bag_theme_id')->constrained();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyText('name')->nullable();
            $table->text('image_path');
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
        Schema::dropIfExists('haven_bags');
    }
};
