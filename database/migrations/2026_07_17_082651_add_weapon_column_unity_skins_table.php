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
            $table->unsignedInteger('weapon_id')->nullable()->after('shield_id');

            // Ajout des clés étrangères
            $table->foreign('weapon_id')->references('dofus_id')->on('items')->nullOnDelete();
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
            $table->dropColumn(["weapon_id"]);
        });
    }
};
