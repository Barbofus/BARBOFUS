<?php

namespace Database\Seeders;

use App\Models\Build;
use App\Models\Element;
use App\Models\User;
use Illuminate\Database\Seeder;
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
        //User::factory(10)->create();

        // $primaryElements = Element::where('is_elemental', 1)->get();
        // $secondaryElements = Element::where('is_elemental', 0)->get();

        // //Build::factory(10)->create();
        // Build::factory(114)->create()->each(function($build) use ($primaryElements, $secondaryElements) {
        //     $build->Element()->attach(
        //         $primaryElements->random(rand(1, 4))->pluck('id')->toArray()
        //     );
        //     $build->Element()->attach(
        //         $secondaryElements->random(rand(0, 1))->pluck('id')->toArray()
        //     );
        // });
    }
}
