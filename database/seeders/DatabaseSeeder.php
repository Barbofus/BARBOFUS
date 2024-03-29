<?php

namespace Database\Seeders;

use App\Models\DofusItemsSubCategorie;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Création des sous-catégories d'items
        DofusItemsSubCategorie::factory()->create([
            'name' => 'Mimibiotable',
            'icon_path' => 'images/icons/items/subcategories/mimibiote.png',
        ]);
        DofusItemsSubCategorie::factory()->create([
            'name' => 'Objet d\'apparat',
            'icon_path' => 'images/icons/items/subcategories/cosmetique.png',
        ]);
        DofusItemsSubCategorie::factory()->create([
            'name' => 'Objet vivant',
            'icon_path' => 'images/icons/items/subcategories/objet_vivant.png',
        ]);

        // Création des 3 roles
        Role::factory()->create([
            'name' => 'Utilisateur',
        ]);
        Role::factory()->create([
            'name' => 'Modérateur',
        ]);
        Role::factory()->create([
            'name' => 'Administrateur',
        ]);

        // Création des 3 comptes de test
        /*User::factory()->create([
            'name' => 'Utilisateur',
            'email' => 'user@gmail.com',
            'password' => Hash::make('testtest'),
            'role_id' => Role::where('name', '=', 'Utilisateur')->first()->id,
        ]);
        User::factory()->create([
            'name' => 'Modérateur',
            'email' => 'modo@gmail.com',
            'password' => Hash::make('testtest'),
            'role_id' => Role::where('name', '=', 'Modérateur')->first()->id,
        ]);
        User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('testtest'),
            'role_id' => Role::where('name', '=', 'Administrateur')->first()->id,
        ]);*/

        $this->call([

            // Création des 19 classes de Dofus
            RaceSeeder::class,

            // Création des 3 types de rewards
            RewardPriceSeeder::class,

            // Création des users
            //UserSeeder::class,

            //Création des skins avec les likes et récompenses
            //SkinSeeder::class,
        ]);
    }
}
