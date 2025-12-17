<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('unity_skins', function (Blueprint $table) {
            $table->unsignedInteger('chunk_views')->default(0)->after('status');
            $table->unsignedInteger('detailed_views')->default(0)->after('chunk_views');
            $table->unsignedInteger('total_views')->virtualAs('chunk_views + detailed_views')->after('detailed_views');

            // Index pour les tris par vues
            $table->index('total_views');
            $table->index('chunk_views');
            $table->index('detailed_views');
        });
    }

    public function down()
    {
        Schema::table('unity_skins', function (Blueprint $table) {
            $table->dropIndex(['total_views']);
            $table->dropIndex(['chunk_views']);
            $table->dropIndex(['detailed_views']);
            $table->dropColumn(['chunk_views', 'detailed_views', 'total_views']);
        });
    }
};
