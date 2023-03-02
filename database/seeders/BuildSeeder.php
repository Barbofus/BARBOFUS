<?php

namespace Database\Seeders;

use App\Models\Build;
use App\Models\Element;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BuildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


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
