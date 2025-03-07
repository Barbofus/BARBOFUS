<?php

use App\Enums\LocaleEnum;
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
        Schema::create('localized_haven_bag_themes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('dofus_id');
            $table->enum('locale', LocaleEnum::values());
            $table->string('name');
            $table->timestamps();

            $table->unique(['dofus_id', 'locale']);

            $table->index('dofus_id');
            $table->index('locale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localized_haven_bag_themes');
    }
};
