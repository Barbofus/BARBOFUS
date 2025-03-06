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
            $table->unsignedInteger('hat_id')->nullable()->after('id');
            $table->unsignedInteger('cape_id')->nullable()->after('hat_id');
            $table->unsignedInteger('shield_id')->nullable()->after('cape_id');
            $table->unsignedInteger('pet_id')->nullable()->after('shield_id');
            $table->unsignedInteger('costume_id')->nullable()->after('pet_id');
            $table->unsignedInteger('wings_id')->nullable()->after('costume_id');
            $table->unsignedInteger('shoulderpads_id')->nullable()->after('wings_id');

            // Ajout des clés étrangères
            $table->foreign('hat_id')->references('dofus_id')->on('items')->nullOnDelete();
            $table->foreign('cape_id')->references('dofus_id')->on('items')->nullOnDelete();
            $table->foreign('shield_id')->references('dofus_id')->on('items')->nullOnDelete();
            $table->foreign('pet_id')->references('dofus_id')->on('items')->nullOnDelete();
            $table->foreign('costume_id')->references('dofus_id')->on('items')->nullOnDelete();
            $table->foreign('wings_id')->references('dofus_id')->on('items')->nullOnDelete();
            $table->foreign('shoulderpads_id')->references('dofus_id')->on('items')->nullOnDelete();
        });

        Schema::table('skins', function (Blueprint $table) {
            $table->unsignedInteger('hat_id')->nullable()->after('id');
            $table->unsignedInteger('cape_id')->nullable()->after('hat_id');
            $table->unsignedInteger('shield_id')->nullable()->after('cape_id');
            $table->unsignedInteger('pet_id')->nullable()->after('shield_id');
            $table->unsignedInteger('costume_id')->nullable()->after('pet_id');

            // Ajout des clés étrangères
            $table->foreign('hat_id')->references('dofus_id')->on('items')->nullOnDelete();
            $table->foreign('cape_id')->references('dofus_id')->on('items')->nullOnDelete();
            $table->foreign('shield_id')->references('dofus_id')->on('items')->nullOnDelete();
            $table->foreign('pet_id')->references('dofus_id')->on('items')->nullOnDelete();
            $table->foreign('costume_id')->references('dofus_id')->on('items')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skin', function (Blueprint $table) {
            //
        });
    }
};
