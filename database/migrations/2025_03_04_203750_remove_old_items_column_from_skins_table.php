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
        Schema::table('skins', function (Blueprint $table) {
            $table->dropForeign('skins_dofus_item_hat_id_foreign');
            $table->dropForeign('skins_dofus_item_shield_id_foreign');
            $table->dropForeign('skins_dofus_item_cloak_id_foreign');
            $table->dropForeign('skins_dofus_item_pet_id_foreign');
            $table->dropForeign('skins_dofus_item_costume_id_foreign');

            $table->dropColumn('dofus_item_hat_id');
            $table->dropColumn('dofus_item_shield_id');
            $table->dropColumn('dofus_item_cloak_id');
            $table->dropColumn('dofus_item_pet_id');
            $table->dropColumn('dofus_item_costume_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skins', function (Blueprint $table) {
            //
        });
    }
};
