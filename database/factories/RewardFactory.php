<?php

namespace Database\Factories;

use App\Models\RewardPrice;
use App\Models\Skin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reward>
 */
class RewardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-30 day' );
        $rank = RewardPrice::all()->random();

        return [
            'skin_id' => Skin::all()->random(),
            'reward_price_id' => $rank,
            'points' => $rank->points,
            'created_at' => $date
        ];
    }
}
