<?php

namespace Database\Factories;

use App\Models\DofusItemCloak;
use App\Models\DofusItemCostume;
use App\Models\DofusItemHat;
use App\Models\DofusItemPet;
use App\Models\DofusItemShield;
use App\Models\Race;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skin>
 */
class SkinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-30 day');

        return [
            'dofus_item_hat_id' => rand(0, 4) ? DofusItemHat::all()->random()->id : null,
            'dofus_item_cloak_id' => rand(0, 4) ? DofusItemCloak::all()->random()->id : null,
            'dofus_item_shield_id' => rand(0, 4) ? DofusItemShield::all()->random()->id : null,
            'dofus_item_pet_id' => rand(0, 4) ? DofusItemPet::all()->random()->id : null,
            'dofus_item_costume_id' => rand(0, 4) ? DofusItemCostume::all()->random()->id : null,
            'face' => rand(1, 8),
            'image_path' => 'images/skins/Skin'.rand(1, 6).'.png',
            'gender' => rand(0, 1) ? 'Femme' : 'Homme',
            'color_skin' => $this->GetRandomColor(),
            'color_hair' => $this->GetRandomColor(),
            'color_cloth_1' => $this->GetRandomColor(),
            'color_cloth_2' => $this->GetRandomColor(),
            'color_cloth_3' => $this->GetRandomColor(),
            'user_id' => rand(0, 3) ? User::all()->random()->id : User::where('name', '=', 'Barbe Douce')->first(),
            'race_id' => Race::all()->random()->id,
            'status' => rand(0, 20) ? 'Posted' : 'Pending',
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }

    protected function GetRandomColor(): string
    {
        return $this->GetRandomColorPart().$this->GetRandomColorPart().$this->GetRandomColorPart();
    }

    protected function GetRandomColorPart(): string
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }
}
