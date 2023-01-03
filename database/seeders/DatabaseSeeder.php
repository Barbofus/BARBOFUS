<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Build;
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

        User::factory(30)->create();

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


        // Création des builds random, 114 au total soit environ 6 par classes, ils auront aléatoirement 1 à 4
            // élements primordiaux + 0 ou 1 élement secondaire (do cri / do pou)
        $primaryElements = Element::where('is_elemental', 1)->get();
        $secondaryElements = Element::where('is_elemental', 0)->get();

        Build::factory(114)->create()->each(function($build) use ($primaryElements, $secondaryElements) {
            $build->Element()->attach(
                $primaryElements->random(rand(1, 4))->pluck('id')->toArray()
            );
            $build->Element()->attach(
                $secondaryElements->random(rand(0, 1))->pluck('id')->toArray()
            );
        });
    }
}
