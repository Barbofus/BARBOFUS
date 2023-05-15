<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Création des 3 types de rewards
        Reward::factory()->create([
            'rank' => 'first',
            'value' => 2
        ]);

        Reward::factory()->create([
            'rank' => 'second',
            'value' => 21
        ]);

        Reward::factory()->create([
            'rank' => 'third',
            'value' => 211
        ]);
    }
}
