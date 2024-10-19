<?php

namespace Database\Seeders;

use App\Models\UnityLike;
use Illuminate\Database\Seeder;

class UnityLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnityLike::factory(50)->create();
    }
}
