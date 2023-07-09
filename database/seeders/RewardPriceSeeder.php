<?php

namespace Database\Seeders;

use App\Models\RewardPrice;
use Illuminate\Database\Seeder;

class RewardPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Création des 3 types de rewards
        RewardPrice::factory()->create([
            'rank' => 'first',
            'points' => 211,
        ]);

        RewardPrice::factory()->create([
            'rank' => 'second',
            'points' => 21,
        ]);

        RewardPrice::factory()->create([
            'rank' => 'third',
            'points' => 2,
        ]);
    }
}
