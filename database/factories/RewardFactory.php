<?php

namespace Database\Factories;

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
        $arrayValues = ['Third', 'Second', 'First'];
        $rand = rand(0,2);

        return [
            'skin_id' => Skin::all()->random()->id,
            'reward_rank' => $arrayValues[$rand],
            'reward_value' => 2 ** ($rand + 1)
        ];
    }
}
