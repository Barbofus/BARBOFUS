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
        Schema::create('dofus_item_cloaks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('dofus_id');
            $table->integer('level');
            $table->foreignId('dofus_items_sub_categorie_id')->constrained();
            $table->string('icon_path');
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
        Schema::dropIfExists('dofus_item_cloaks');
    }
};
