<?php

use App\Enums\ItemCategorieEnum;
use App\Enums\ItemSubcategorieEnum;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('dofus_id')->unique();
            $table->unsignedTinyInteger('level');
            $table->enum('category', ItemCategorieEnum::values());
            $table->enum('subcategory', ItemSubcategorieEnum::values());
            $table->enum('pet_type', ['dragodinde', 'muldo', 'volkorne', 'montilier', 'familier'])->nullable();
            $table->string('icon_path');
            $table->timestamps();

            $table->index('dofus_id');
            $table->index('category');
            $table->index('subcategory');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
