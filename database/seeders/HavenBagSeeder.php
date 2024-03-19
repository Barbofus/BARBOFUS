<?php

namespace Database\Seeders;

use App\Models\HavenBag;
use Illuminate\Database\Seeder;

class HavenBagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HavenBag::factory(50)->create();
    }
}
