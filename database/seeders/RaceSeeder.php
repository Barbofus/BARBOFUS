<?php

namespace Database\Seeders;

use App\Models\Race;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

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
                'ghost_icon_path' => 'images/icons/classes/ghost/L'. $key + 1 .'_'. ucfirst(\Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($value) ).'_Tr.png',
                'colored_icon_path' => 'images/icons/classes/colored/L'. $key + 1 .'_'. ucfirst(\Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($value) ).'_Co.png',
            ]);
        }
    }
}
