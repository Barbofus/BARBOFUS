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
        Schema::create('heaven_bag_themes', function (Blueprint $table) {
            $table->id();
            $table->integer('dofus_id');
            $table->tinyText('name');
            $table->text('image_path');
            $table->text('popocket_icon_path');
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
        Schema::dropIfExists('heaven_bag_themes');
    }
};
