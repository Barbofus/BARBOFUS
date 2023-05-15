<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Reward;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 500;
        Skin::factory($count)->create();
        Like::factory(count(User::all()) * 75)->create();

        for ($i = 0; $i < 30; $i++)
        {
            $skin = Skin::get()->random();

            $skin->Rewards()->attach(rand(1,3));
        }
    }
}
