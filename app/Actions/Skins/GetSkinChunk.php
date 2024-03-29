<?php

declare(strict_types=1);

namespace App\Actions\Skins;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class GetSkinChunk
{
    /**
     * @param  int[]  $skinIds
     * @return Collection<int|string, mixed>
     */
    public function __invoke($skinIds)
    {
        $skins = DB::table('skins')
            ->select('id', 'image_path', 'user_id', 'updated_at', 'status')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id')
                    ->take(1),
            ])
            ->addSelect([
                'is_liked' => DB::table('likes')
                    ->select('id')
                    ->whereColumn('skin_id', 'skins.id')
                    ->where('user_id', Auth::id())
                    ->take(1),
            ])
            ->addSelect([
                'liked_at' => DB::table('likes')
                    ->select('created_at')
                    ->whereColumn('skin_id', 'skins.id')
                    ->where('user_id', Auth::id())
                    ->take(1),
            ])
            ->addSelect([
                'likes_count' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('skin_id', 'skins.id'),
            ])
            ->addSelect([
                'reward_id' => DB::table('rewards')
                    ->select('rank')
                    ->whereColumn('skin_id', 'skins.id')
                    ->orderBy('rank', 'ASC')
                    ->take(1),
            ])
            ->addSelect([
                'second_reward_id' => DB::table('rewards')
                    ->select('rank')
                    ->whereColumn('skin_id', 'skins.id')
                    ->orderBy('rank', 'ASC')
                    ->skip(1)
                    ->take(1),
            ])
            ->addSelect([
                'third_reward_id' => DB::table('rewards')
                    ->select('rank')
                    ->whereColumn('skin_id', 'skins.id')
                    ->orderBy('rank', 'ASC')
                    ->skip(2)
                    ->take(1),
            ])
            ->whereIn('id', $skinIds)
            ->get();

        foreach ($skins as $skin) {
            $skin->liked_at = new Carbon($skin->liked_at);
            $skin->updated_at = new Carbon($skin->updated_at);
        }

        return collect($skinIds)->map(function ($id) use ($skins) {
            return $skins->where('id', $id)->first();
        });
    }
}
