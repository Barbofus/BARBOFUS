<?php

namespace Database\Seeders;

use App\Models\HeavenBag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeavenBagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HeavenBag::factory(50)->create();
    }
}
