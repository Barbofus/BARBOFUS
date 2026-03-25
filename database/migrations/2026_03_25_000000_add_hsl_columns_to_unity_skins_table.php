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
        Schema::table('unity_skins', function (Blueprint $table) {
            $table->unsignedSmallInteger('color_cloth_1_hue')->nullable();
            $table->unsignedTinyInteger('color_cloth_1_saturation')->nullable();
            $table->unsignedTinyInteger('color_cloth_1_lightness')->nullable();

            $table->unsignedSmallInteger('color_cloth_2_hue')->nullable();
            $table->unsignedTinyInteger('color_cloth_2_saturation')->nullable();
            $table->unsignedTinyInteger('color_cloth_2_lightness')->nullable();

            $table->unsignedSmallInteger('color_cloth_3_hue')->nullable();
            $table->unsignedTinyInteger('color_cloth_3_saturation')->nullable();
            $table->unsignedTinyInteger('color_cloth_3_lightness')->nullable();

            $table->unsignedSmallInteger('color_cloth_4_hue')->nullable();
            $table->unsignedTinyInteger('color_cloth_4_saturation')->nullable();
            $table->unsignedTinyInteger('color_cloth_4_lightness')->nullable();

            $table->index('color_cloth_1_hue', 'idx_cloth1_hue');
            $table->index('color_cloth_2_hue', 'idx_cloth2_hue');
            $table->index('color_cloth_3_hue', 'idx_cloth3_hue');
            $table->index('color_cloth_4_hue', 'idx_cloth4_hue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unity_skins', function (Blueprint $table) {
            $table->dropColumn([
                'color_cloth_1_hue',
                'color_cloth_1_saturation',
                'color_cloth_1_lightness',
                'color_cloth_2_hue',
                'color_cloth_2_saturation',
                'color_cloth_2_lightness',
                'color_cloth_3_hue',
                'color_cloth_3_saturation',
                'color_cloth_3_lightness',
                'color_cloth_4_hue',
                'color_cloth_4_saturation',
                'color_cloth_4_lightness',
            ]);
        });
    }
};
