<?php

declare(strict_types=1);

namespace App\Actions\MissSkin;

use App\Actions\Discord\SendDiscordMissSkinWebhook;
use App\Models\Reward;
use App\Models\RewardPrice;
use App\Models\SkinWinner;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class FindWinners
{
    /**
     * @return void
     */
    public function __invoke()
    {
        // Trouve les 3 skins ayant le plus de likes durant la semaine
        $winners = DB::table('skins')
            ->join('users', 'skins.user_id', '=', 'users.id')
            ->addSelect([
                'weekly_like_count' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('skin_id', 'skins.id')
                    ->whereDate('created_at', '>', Carbon::today()->subWeek()->subDay()->toDateString()),

                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id'),
            ])
            ->where('users.name', '!=', 'Barbe Douce')
            ->orderByRaw('weekly_like_count DESC')
            ->orderBy('updated_at', 'ASC')
            ->take(3)
            ->get()
            ->toArray();

        $previousWinners = SkinWinner::all();

        foreach ($previousWinners as $previousWinner) {
            if (Storage::exists($previousWinner->image_path)) {
                Storage::delete($previousWinner->image_path);
            }
        }

        SkinWinner::truncate();

        foreach ($winners as $key => $winner) {

            $newPath = 'images/winners/winner_'.$key.'.png';
            Storage::copy($winner->image_path, $newPath);

            // Créer les 3 skins à afficher
            SkinWinner::create([
                'skin_id' => $winner->id,
                'reward_id' => $key + 1,
                'user_name' => $winner->user_name,
                'image_path' => $newPath,
                'weekly_likes' => $winner->weekly_like_count,
                'skin_name' => $winner->name,
            ]);

            // Ajoute les vainqueurs dans la table des vainqueurs
            Reward::create([
                'skin_id' => $winner->id,
                'rank' => $key + 1,
                'points' => RewardPrice::find($key + 1)->points,
            ]);
        }

        (new SendDiscordMissSkinWebhook)(config('app.miss_skin_webhook_url'));
    }
}
