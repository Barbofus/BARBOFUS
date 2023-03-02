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
        Schema::create('skins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dofus_item_hat_id')->constrained();
            $table->foreignId('dofus_item_shield_id')->constrained();
            $table->foreignId('dofus_item_cloak_id')->constrained();
            $table->foreignId('dofus_item_pet_id')->constrained();
            $table->foreignId('dofus_item_costume_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('race_id')->constrained();
            $table->integer('face');
            $table->string('image_path');
            $table->string('gender');
            $table->string('color_skin');
            $table->string('color_hair');
            $table->string('color_cloth_1');
            $table->string('color_cloth_2');
            $table->string('color_cloth_3');
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
        Schema::dropIfExists('skins');
    }
};
