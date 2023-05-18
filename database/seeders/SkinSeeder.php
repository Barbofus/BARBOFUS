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
        Like::factory($count * 40)->create();
        Reward::factory(round($count * 0.02) * 3)->create();
    }
}
