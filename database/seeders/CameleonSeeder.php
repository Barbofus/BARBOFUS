<?php

namespace Database\Seeders;

use App\Models\DofusItemPet;
use Illuminate\Database\Seeder;

class CameleonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DofusItemPet::factory()->create([
            'name' => 'Dragodinde Caméléone',
            'dofus_id' => -1,
            'level' => '60',
            'icon_path' => 'images/icons/items/pets/dragodinde.png',
            'dofus_items_sub_categorie_id' => 1,
            'type' => 'dragodinde',
        ]);

        DofusItemPet::factory()->create([
            'name' => 'Muldo Caméléon',
            'dofus_id' => -2,
            'level' => '60',
            'icon_path' => 'images/icons/items/pets/muldo.png',
            'dofus_items_sub_categorie_id' => 1,
            'type' => 'muldo',
        ]);

        DofusItemPet::factory()->create([
            'name' => 'Volkorne Caméléone',
            'dofus_id' => -3,
            'level' => '60',
            'icon_path' => 'images/icons/items/pets/volkorne.png',
            'dofus_items_sub_categorie_id' => 1,
            'type' => 'volkorne',
        ]);
    }
}
