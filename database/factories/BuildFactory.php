<?php

namespace Database\Factories;

use App\Models\Race;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\\Build>
 */
class BuildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $chosenRace = Race::all()->random()->id;
        $is_pvp = $this->faker->randomElement(['PVP', 'PVM']);

        return [
            'title' => $is_pvp. ' ' .Race::find($chosenRace)->name,
            'build_link' => 'https://dofusroom.com/b-303022',
            'image_path' => 'images/builds/MNzbHGFJPB5DB1ipVIuNDFl34I86l5N3YaryanjQ.webp',
            'ap_nbr' => $this->faker->numberBetween(11,12),
            'mp_nbr' => 6,
            'user_id' => User::find(5),
            'race_id' => $chosenRace,
            'is_pvp' => $is_pvp === 'PVP' ? 1 : 0,
        ];
    }
}
