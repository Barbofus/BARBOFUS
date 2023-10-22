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
        Schema::table('dofus_item_pets', function (Blueprint $table) {
            $table->enum('type', ['familier', 'montilier', 'dragodinde', 'volkorne', 'muldo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dofus_item_pets', function (Blueprint $table) {
            //
        });
    }
};
