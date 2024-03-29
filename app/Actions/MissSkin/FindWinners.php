<?php

declare(strict_types=1);

namespace App\Actions\MissSkin;

use App\Models\Reward;
use App\Models\RewardPrice;
use App\Models\SkinWinner;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class FindWinners
{
    /**
     * @return void
     */
    public function __invoke()
    {
        // Trouve les 3 skins ayant le plus de likes durant la semaine
        $winners = DB::table('skins')
            ->addSelect([
                'weekly_like_count' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('skin_id', 'skins.id')
                    ->whereDate('created_at', '>', Carbon::today()->subWeek()->toDateString()),

                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id'),
            ])
            ->orderByRaw('weekly_like_count DESC')
            ->orderBy('updated_at', 'ASC')
            ->take(3)
            ->get()
            ->toArray();

        SkinWinner::truncate();

        foreach ($winners as $key => $winner) {

            // Créer les 3 skins à afficher
            SkinWinner::create([
                'skin_id' => $winner->id,
                'reward_id' => $key + 1,
                'user_name' => $winner->user_name,
                'image_path' => $winner->image_path,
                'weekly_likes' => $winner->weekly_like_count,
            ]);

            // Ajoute les vainqueurs dans la table des vainqueurs
            Reward::create([
                'skin_id' => $winner->id,
                'rank' => $key + 1,
                'points' => RewardPrice::find($key + 1)->points,
            ]);
        }
    }
}
