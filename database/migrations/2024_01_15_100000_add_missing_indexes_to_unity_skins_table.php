<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('unity_skins', function (Blueprint $table) {
            // Index composites (toujours créés car plus spécifiques)
            $table->index(['status', 'created_at']);
            $table->index(['status', 'race_id']);
            $table->index(['user_id', 'created_at']);

            // Index simples (vérifiés)
            if (!$this->indexExists('unity_skins', 'unity_skins_status_index')) {
                $table->index('status');
            }
            if (!$this->indexExists('unity_skins', 'unity_skins_race_id_index')) {
                $table->index('race_id');
            }
            if (!$this->indexExists('unity_skins', 'unity_skins_gender_index')) {
                $table->index('gender');
            }
            if (!$this->indexExists('unity_skins', 'unity_skins_created_at_index')) {
                $table->index('created_at');
            }

            // Index pour les colonnes d'items (filtres de contenu)
            $table->index('hat_id');
            $table->index('cape_id');
            $table->index('shield_id');
            $table->index('pet_id');
            $table->index('costume_id');
            $table->index('wings_id');
            $table->index('shoulderpads_id');
        });

        Schema::table('unity_likes', function (Blueprint $table) {
            $table->index('unity_skin_id'); // Pour count(likes)
        });

        Schema::table('unity_rewards', function (Blueprint $table) {
            $table->index('unity_skin_id'); // Pour sum(points)
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('name'); // Pour filtre "Barbe Douce"
        });
    }

    public function down()
    {
        Schema::table('unity_skins', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['race_id']);
            $table->dropIndex(['gender']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['status', 'race_id']);
            $table->dropIndex(['user_id', 'created_at']);
            $table->dropIndex(['hat_id']);
            $table->dropIndex(['cape_id']);
            $table->dropIndex(['shield_id']);
            $table->dropIndex(['pet_id']);
            $table->dropIndex(['costume_id']);
            $table->dropIndex(['wings_id']);
            $table->dropIndex(['shoulderpads_id']);
        });

        Schema::table('unity_likes', function (Blueprint $table) {
            $table->dropIndex(['unity_skin_id']);
        });

        Schema::table('unity_rewards', function (Blueprint $table) {
            $table->dropIndex(['unity_skin_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
    }

    private function indexExists($table, $index): bool
    {
        try {
            return collect(DB::select("SHOW INDEX FROM {$table}"))->pluck('Key_name')->contains($index);
        } catch (\Exception $e) {
            return false;
        }
    }
};
