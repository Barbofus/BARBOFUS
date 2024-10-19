<?php

namespace App\Http\Livewire\UnitySkin;

use App\Actions\Likes\SwitchLikes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class UnitySkinIndexChunk extends Component
{
    /**
     * @var int[]
     */
    public $skinIds;

    public int $page;

    public int $itemsPerPage;

    /**
     * @return View
     */
    public function render()
    {
        $skins = DB::table('unity_skins')
            ->select('id', 'image_path', 'user_id', 'created_at', 'status', 'name')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'unity_skins.user_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_name' => DB::table('races')
                    ->select('name')
                    ->whereColumn('id', 'unity_skins.race_id')
                    ->take(1),
            ])
            ->addSelect([
                'is_liked' => DB::table('unity_likes')
                    ->select('id')
                    ->whereColumn('unity_skin_id', 'unity_skins.id')
                    ->where('user_id', Auth::id())
                    ->orWhereColumn('unity_skin_id', 'unity_skins.id')
                    ->where('ip_adress', request()->ip())
                    ->take(1),
            ])
            ->addSelect([
                'liked_at' => DB::table('unity_likes')
                    ->select('created_at')
                    ->whereColumn('unity_skin_id', 'unity_skins.id')
                    ->where('user_id', Auth::id())
                    ->take(1),
            ])
            ->addSelect([
                'likes_count' => DB::table('unity_likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('unity_skin_id', 'unity_skins.id'),
            ])
            ->addSelect([
                'reward_id' => DB::table('unity_rewards')
                    ->select('rank')
                    ->whereColumn('unity_skin_id', 'unity_skins.id')
                    ->orderBy('rank', 'ASC')
                    ->take(1),
            ])
            ->addSelect([
                'second_reward_id' => DB::table('unity_rewards')
                    ->select('rank')
                    ->whereColumn('unity_skin_id', 'unity_skins.id')
                    ->orderBy('rank', 'ASC')
                    ->skip(1)
                    ->take(1),
            ])
            ->addSelect([
                'third_reward_id' => DB::table('unity_rewards')
                    ->select('rank')
                    ->whereColumn('unity_skin_id', 'unity_skins.id')
                    ->orderBy('rank', 'ASC')
                    ->skip(2)
                    ->take(1),
            ])
            ->addSelect([DB::raw('true as is_unity_skin')])
            ->whereIn('id', $this->skinIds)
            ->get();

        foreach ($skins as $skin) {
            $skin->liked_at = new Carbon($skin->liked_at);
            $skin->created_at = new Carbon($skin->created_at);
        }

        $orderedSkins = collect($this->skinIds)->map(function ($id) use ($skins) {
            return $skins->where('id', $id)->first();
        });

        return view('livewire.unity-skin.unity-skin-index-chunk', [
            'skins' => $orderedSkins,
        ]);
    }

    /**
     * @return void
     */
    public function SwitchHeart(int $skinID)
    {
        (new SwitchLikes)($skinID, true);
    }
}
