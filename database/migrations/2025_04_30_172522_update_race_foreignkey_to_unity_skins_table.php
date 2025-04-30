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
            // 1. Ajouter une colonne temporaire
            $table->unsignedBigInteger('new_race_id')->nullable()->after('race_id');
        });

        // 2. Copier les dofus_id correspondants dans new_race_id
        DB::statement('
            UPDATE unity_skins
            JOIN races ON unity_skins.race_id = races.id
            SET unity_skins.new_race_id = races.dofus_id
        ');

        Schema::table('unity_skins', function (Blueprint $table) {
            // 3. Supprimer l'ancienne contrainte
            $table->dropForeign(['race_id']);

            // 4. Supprimer l'ancienne colonne et renommer la nouvelle
            $table->dropColumn('race_id');
        });

        Schema::table('unity_skins', function (Blueprint $table) {
            $table->renameColumn('new_race_id', 'race_id');
        });

        Schema::table('unity_skins', function (Blueprint $table) {
            // 5. Ajouter la nouvelle contrainte vers dofus_id
            $table->foreign('race_id')
                ->references('dofus_id')
                ->on('races');
        });
    }

    public function down()
    {
        // Inversion de la logique, si besoin
        Schema::table('unity_skins', function (Blueprint $table) {
            $table->dropForeign(['race_id']);
            $table->unsignedBigInteger('old_race_id')->nullable()->after('race_id');
        });

        DB::statement('
            UPDATE unity_skins
            JOIN races ON unity_skins.race_id = races.dofus_id
            SET unity_skins.old_race_id = races.id
        ');

        Schema::table('unity_skins', function (Blueprint $table) {
            $table->dropColumn('race_id');
        });

        Schema::table('unity_skins', function (Blueprint $table) {
            $table->renameColumn('old_race_id', 'race_id');
        });

        Schema::table('unity_skins', function (Blueprint $table) {
            $table->foreign('race_id')
                ->references('id')
                ->on('races');
        });
    }
};
