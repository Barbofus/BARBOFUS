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
        // 1. Ajouter une colonne temporaire
        Schema::table('unity_skins', function (Blueprint $table) {
            $table->tinyInteger('new_gender')->nullable()->after('gender');
        });

        // 2. Transférer les données ("Homme" => 0, "Femme" => 1)
        DB::table('unity_skins')->where('gender', 'Homme')->update(['new_gender' => 0]);
        DB::table('unity_skins')->where('gender', 'Femme')->update(['new_gender' => 1]);

        // 3. Supprimer l'ancienne colonne
        Schema::table('unity_skins', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        // 4. Renommer la nouvelle colonne
        Schema::table('unity_skins', function (Blueprint $table) {
            $table->renameColumn('new_gender', 'gender');
        });
    }

    public function down()
    {
        // Inverser : repasser de 0/1 à Homme/Femme
        Schema::table('unity_skins', function (Blueprint $table) {
            $table->string('old_gender')->nullable()->after('gender');
        });

        DB::table('unity_skins')->where('gender', 0)->update(['old_gender' => 'Homme']);
        DB::table('unity_skins')->where('gender', 1)->update(['old_gender' => 'Femme']);

        Schema::table('unity_skins', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('unity_skins', function (Blueprint $table) {
            $table->renameColumn('old_gender', 'gender');
        });
    }
};
