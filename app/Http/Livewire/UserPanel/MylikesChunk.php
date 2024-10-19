<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\Likes\SwitchLikes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class MylikesChunk extends Component
{
    public $skinIds;

    public int $page;

    public int $itemsPerPage;

    /**
     * @return View
     */
    public function render()
    {
        $filteredArray = array_filter($this->skinIds, function ($item) {
            return $item->is_unity_skin === 1;
        });

        $unitySkinIdsArray = array_map(function ($item) {
            return $item->id;
        }, $filteredArray);

        $filteredArray = array_filter($this->skinIds, function ($item) {
            return $item->is_unity_skin === 0;
        });

        $skinIdsArray = array_map(function ($item) {
            return $item->id;
        }, $filteredArray);

        $baseSkins = DB::table('skins')
            ->select('id', 'image_path', 'user_id', 'created_at', 'status', 'name')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_name' => DB::table('races')
                    ->select('name')
                    ->whereColumn('id', 'skins.race_id')
                    ->take(1),
            ])
            ->addSelect([DB::raw('true as is_liked')])
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
            ->addSelect([DB::raw('false as is_unity_skin')])
            ->whereIn('id', $skinIdsArray)
            ->get();

        $unitySkins = DB::table('unity_skins')
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
            ->addSelect([DB::raw('true as is_liked')])
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
            ->whereIn('id', $unitySkinIdsArray)
            ->get();

        $skins = $baseSkins->merge($unitySkins)->sortByDesc('liked_at');

        foreach ($skins as $skin) {
            $skin->liked_at = new Carbon($skin->liked_at);
            $skin->created_at = new Carbon($skin->created_at);
        }

        /*$orderedSkins = collect($skinIds)->map(function ($id) use ($skins) {
            return $skins->where('id', $id)->first();
        });*/

        return view('livewire.user-panel.mylikes-chunk', [
            'skins' => $skins->values(),
        ]);
    }

    /**
     * @return void
     */
    public function SwitchHeart(int $skinID, bool $isUnity = false)
    {
        (new SwitchLikes)($skinID, $isUnity);
        $this->emit('ReloadInfinite');

        $this->skipRender();
    }
}
