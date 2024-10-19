<?php

declare(strict_types=1);

namespace App\Actions\MissSkin;

use App\Actions\Discord\SendDiscordMissSkinWebhook;
use App\Models\Reward;
use App\Models\RewardPrice;
use App\Models\Skin;
use App\Models\SkinWinner;
use App\Models\UnityReward;
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

        // Utilisé pour les concours avec une participation par personne, jusqu'à $topTen inclut
        /*$winnerIds = DB::table('skins')
            ->join('users', 'skins.user_id', '=', 'users.id')
            ->select('skins.id')
            ->addSelect([
                'weekly_like_count' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('skin_id', 'skins.id')
                    ->whereDate('created_at', '>', Carbon::parse('last Tuesday 09:00:00')->subDay()),
            ])
            ->where('users.name', '!=', 'Barbe Douce')
            ->orderByRaw('weekly_like_count DESC')
            ->orderBy('skins.updated_at', 'ASC')
            ->pluck('skins.id')
            ->toArray();

        $skins = DB::table('skins')
            ->whereIn('id', $winnerIds)
            ->select('id')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id')
                    ->take(1),
            ])
            ->addSelect([
                'weekly_like_count' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('skin_id', 'skins.id')
                    ->whereDate('created_at', '>', Carbon::parse('last Tuesday 09:00:00')->subDay()),
            ])
            ->orderBy('weekly_like_count', 'DESC')
            ->get()->toArray();

        $toRemove = [];
        $foundName = [];

        foreach ($skins as $skin) {
            if (in_array($skin->user_name, $foundName)) {
                $toRemove[] = $skin->id;

                continue;
            }
            $foundName[] = $skin->user_name;
        }

        foreach ($toRemove as $rem) {
            if (($key = array_search($rem, $winnerIds)) !== false) {
                unset($winnerIds[$key]);
            }
        }

        $winners = DB::table('skins')
            ->whereIn('id', $winnerIds)
            ->addSelect([
                'weekly_like_count' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('skin_id', 'skins.id')
                    ->whereDate('created_at', '>', Carbon::parse('last Tuesday 09:00:00')->subDay()),

                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id'),
            ])
            ->orderByRaw('weekly_like_count DESC')
            ->orderBy('updated_at', 'ASC')
            ->take(3)
            ->get()
            ->toArray();

        $topTen = Skin::query()
            ->whereIn('id', $winnerIds)
            ->select('id')
            ->addSelect([
                'weekly_like_count' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('skin_id', 'skins.id')
                    ->whereDate('created_at', '>', Carbon::parse('last Tuesday 09:00:00')->subDay()),

                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id'),
            ])
            ->orderByRaw('weekly_like_count DESC')
            ->orderBy('updated_at', 'ASC')
            ->take(10)
            ->get()
            ->toArray();*/

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
            ->orderBy('created_at', 'ASC')
            ->take(3)
            ->get()
            ->toArray();

        $unityWinners = DB::table('unity_skins')
            ->join('users', 'unity_skins.user_id', '=', 'users.id')
            ->addSelect([
                'weekly_like_count' => DB::table('unity_likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('unity_skin_id', 'unity_skins.id')
                    ->whereDate('created_at', '>', Carbon::today()->subWeek()->subDay()->toDateString()),

                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'unity_skins.user_id'),
            ])
            ->where('users.name', '!=', 'Barbe Douce')
            ->orderByRaw('weekly_like_count DESC')
            ->orderBy('created_at', 'ASC')
            ->take(3)
            ->get()
            ->toArray();

        $winners = array_merge($winners, $unityWinners);

        $previousWinners = SkinWinner::all();

        foreach ($previousWinners as $previousWinner) {
            if (Storage::exists($previousWinner->image_path)) {
                Storage::delete($previousWinner->image_path);
            }
        }

        SkinWinner::truncate();

        /*foreach ($winners as $key => $winner) {

            $newPath = 'images/winners/winner_'.$key.'_'.time().'png';
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
        }*/

        // Reward 2.0
        for ($i = 0; $i < 3; $i++) {
            $newPath = 'images/winners/winner_'.$i.'_'.time().'png';
            Storage::copy($winners[$i]->image_path, $newPath);

            // Créer les 3 skins à afficher
            SkinWinner::create([
                'skin_id' => $winners[$i]->id,
                'reward_id' => $i + 1,
                'user_name' => $winners[$i]->user_name,
                'image_path' => $newPath,
                'weekly_likes' => $winners[$i]->weekly_like_count,
                'skin_name' => $winners[$i]->name,
            ]);

            // Ajoute les vainqueurs dans la table des vainqueurs
            Reward::create([
                'skin_id' => $winners[$i]->id,
                'rank' => $i + 1,
                'points' => RewardPrice::find($i + 1)->points,
            ]);
        }

        // Reward Unity
        for ($i = 0; $i < 3; $i++) {
            $newPath = 'images/winners/winner_'.($i + 3).'_'.time().'png';
            Storage::copy($winners[$i + 3]->image_path, $newPath);

            // Créer les 3 skins à afficher
            SkinWinner::create([
                'skin_id' => $winners[$i + 3]->id,
                'reward_id' => $i + 1,
                'user_name' => $winners[$i + 3]->user_name,
                'image_path' => $newPath,
                'weekly_likes' => $winners[$i + 3]->weekly_like_count,
                'skin_name' => $winners[$i + 3]->name,
            ]);

            // Ajoute les vainqueurs dans la table des vainqueurs
            UnityReward::create([
                'unity_skin_id' => $winners[$i + 3]->id,
                'rank' => $i + 1,
                'points' => RewardPrice::find($i + 1)->points,
            ]);
        }

        //(new SendDiscordMissSkinWebhook)(config('app.miss_skin_webhook_url'), $topTen);
        (new SendDiscordMissSkinWebhook)(config('app.miss_skin_webhook_url'), false);
        (new SendDiscordMissSkinWebhook)(config('app.miss_skin_webhook_url'), true);
    }
}
