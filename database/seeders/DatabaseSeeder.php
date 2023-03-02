<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Build;
use App\Models\DofusItemsSubCategorie;
use App\Models\Element;
use App\Models\Race;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Création des sous catégorie d'items
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

        // Création des 3 comptes de test, + des comptes random
        User::factory()->create([
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
        ]);

        // Création des 19 classes de Dofus
        $races = [
            'féca',
            'osamodas',
            'enutrof',
            'sram',
            'xélor',
            'ecaflip',
            'eniripsa',
            'iop',
            'crâ',
            'sadida',
            'sacrieur',
            'pandawa',
            'roublard',
            'zobal',
            'steamer',
            'eliotrope',
            'huppermage',
            'ouginak',
            'forgelance',
        ];

        foreach ($races as $key => $value) {
            Race::factory()->create([
                'name' => ucfirst($value),
                'icon_path' => 'logo-'. \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($value) .'.png',
                'banner_path' => 'banner_'. \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($value) .'.jpg',
            ]);
        }

        // Création des 6 élements
        Element::factory()->create([
            'name' => 'air',
            'icon_path' => 'icon_air.png',
            'is_elemental' => 1,
        ]);
        Element::factory()->create([
            'name' => 'terre',
            'icon_path' => 'icon_terre.png',
            'is_elemental' => 1,
        ]);
        Element::factory()->create([
            'name' => 'eau',
            'icon_path' => 'icon_eau.png',
            'is_elemental' => 1,
        ]);
        Element::factory()->create([
            'name' => 'feu',
            'icon_path' => 'icon_feu.png',
            'is_elemental' => 1,
        ]);
        Element::factory()->create([
            'name' => 'docri',
            'icon_path' => 'icon_docri.png',
            'is_elemental' => 0,
        ]);
        Element::factory()->create([
            'name' => 'dopou',
            'icon_path' => 'icon_dopou.png',
            'is_elemental' => 0,
        ]);

        $this->call([
            UserSeeder::class,
            BuildSeeder::class,
            SkinSeeder::class,
        ]);
    }
}
