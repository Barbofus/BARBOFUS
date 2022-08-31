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

        // $elements = Element::all();

        // //Build::factory(10)->create();
        // Build::factory(35)->create()->each(function($build) use ($elements) {
        //     $build->Element()->attach(
        //         $elements->random(rand(1, 6))->pluck('id')->toArray()
        //     );
        // });=
    }
}
