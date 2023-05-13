<?php

namespace Database\Factories;

use App\Models\Skin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'skin_id' => Skin::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
