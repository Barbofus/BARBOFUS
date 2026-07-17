<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $values = implode(',', array_map(fn($v) => "'$v'", \App\Enums\ItemCategorieEnum::values()));
        DB::statement("ALTER TABLE items MODIFY COLUMN category ENUM($values) NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $oldValues = "'hat','cape','shield','pet','wings','shoulderpads','costume'";
        DB::statement("ALTER TABLE items MODIFY COLUMN category ENUM($oldValues) NOT NULL");
    }
};
