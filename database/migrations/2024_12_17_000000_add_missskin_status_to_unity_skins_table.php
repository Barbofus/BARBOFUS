<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ajouter 'MissSkin' aux valeurs de l'enum status
        DB::statement("ALTER TABLE unity_skins MODIFY COLUMN status ENUM('Posted', 'Refused', 'Pending', 'MissSkin') NOT NULL DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Retirer 'MissSkin' de l'enum (attention: cela supprimera les données avec ce status)
        DB::statement("UPDATE unity_skins SET status = 'Posted' WHERE status = 'MissSkin'");
        DB::statement("ALTER TABLE unity_skins MODIFY COLUMN status ENUM('Posted', 'Refused', 'Pending') NOT NULL DEFAULT 'Pending'");
    }
};
