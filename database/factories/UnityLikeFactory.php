<?php

namespace Database\Factories;

use App\Models\UnityLike;
use App\Models\UnitySkin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnityLikeFactory extends Factory
{
    protected $model = UnityLike::class;

    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-30 day');

        return [
            'unity_skin_id' => UnitySkin::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
