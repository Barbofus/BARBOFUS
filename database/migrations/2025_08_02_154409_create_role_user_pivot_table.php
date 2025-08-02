<?php

use App\Models\User;
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
        // 1. Créer la table pivot role_user
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 2. Migrer les anciens rôles
        User::withoutGlobalScopes()->chunk(100, function ($users) {
            foreach ($users as $user) {
                $roleId = $user->role_id ?: 1; // rôle par défaut si NULL
                $user->roles()->attach($roleId);
            }
        });

        // 3. Supprimer l’ancienne colonne
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 1. Recréer la colonne role_id
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->default(1)->constrained();
        });

        // 2. Remettre les données depuis la pivot
        User::withoutGlobalScopes()->chunk(100, function ($users) {
            foreach ($users as $user) {
                $firstRoleId = $user->roles()->pluck('role_id')->first() ?: 1;
                $user->role_id = $firstRoleId;
                $user->save();
            }
        });

        // 3. Supprimer la table pivot
        Schema::dropIfExists('role_user');
    }
};
