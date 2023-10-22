<?php

namespace Database\Factories;

use App\Models\DofusItemPet;
use App\Models\DofusItemsSubCategorie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DofusItemPetFactory extends Factory
{
    protected $model = DofusItemPet::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'dofus_id' => $this->faker->randomNumber(),
            'level' => $this->faker->randomNumber(),
            'icon_path' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'dofus_items_sub_categorie_id' => DofusItemsSubCategorie::factory(),
        ];
    }
}
