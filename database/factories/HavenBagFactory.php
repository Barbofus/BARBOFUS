<?php

namespace Database\Factories;

use App\Models\HavenBagTheme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HavenBag>
 */
class HavenBagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $heavenBag = HavenBagTheme::all()->random();

        return [
            'haven_bag_theme_id' => $heavenBag->id,
            'user_id' => User::all()->random()->id,
            'name' => rand(0, 2) ? $this->faker->sentence(rand(1,3)) : null,
            'image_path' => $heavenBag->image_path,
        ];
    }
}
