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
        Schema::create('unity_skins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dofus_item_hat_id')->nullable()->constrained();
            $table->foreignId('dofus_item_shield_id')->nullable()->constrained();
            $table->foreignId('dofus_item_cloak_id')->nullable()->constrained();
            $table->foreignId('dofus_item_pet_id')->nullable()->constrained();
            $table->foreignId('dofus_item_costume_id')->nullable()->constrained();

            $table->unsignedBigInteger('dofus_item_wing_id')->nullable();
            $table->unsignedBigInteger('dofus_item_shoulder_id')->nullable();

            $table->foreign('dofus_item_wing_id')->references('id')->on('dofus_item_costumes');
            $table->foreign('dofus_item_shoulder_id')->references('id')->on('dofus_item_costumes');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('race_id')->constrained();
            $table->integer('face');
            $table->string('image_path');
            $table->string('gender');
            $table->string('color_skin');
            $table->string('color_hair');
            $table->string('color_cloth_1');
            $table->string('color_cloth_2');
            $table->string('color_cloth_3');
            $table->string('color_cloth_4');
            $table->enum('status', ['Posted', 'Refused', 'Pending'])->default('Pending');
            $table->text('refused_reason')->nullable();
            $table->tinyText('name')->nullable();
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
        Schema::dropIfExists('unity_skins');
    }
};
