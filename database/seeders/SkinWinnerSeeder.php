<?php

namespace Database\Seeders;

use App\Models\Skin;
use App\Models\SkinWinner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkinWinnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 2; $i++)
        {
            $skin = Skin::all()->random();
            SkinWinner::factory()->create([
                'skin_id' => $skin->id,
                'user_name' => $skin->User->name,
                'image_path' => $skin->image_path,
                'weekly_likes' => ($i + 1) * 17,
                'reward_id' => $i + 1,
            ]);
        }
    }
}
