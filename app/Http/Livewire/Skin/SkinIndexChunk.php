<?php

namespace App\Http\Livewire\Skin;

use App\Actions\Likes\SwitchLikes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SkinIndexChunk extends Component
{
    public $skinIds;
    public $page;
    public $itemsPerPage;

    public function render()
    {
        $skins = DB::table('skins')
            ->select('id', 'image_path', 'user_id')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id')
                    ->take(1)
            ])
            ->addSelect([
                'is_liked' => DB::table('likes')
                    ->select('id')
                    ->whereColumn('skin_id', 'skins.id')
                    ->where('user_id', Auth::id())
                    ->take(1)
            ])
            ->addSelect([
                'likes_count' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('skin_id', 'skins.id')
            ])
            ->addSelect([
                'rewards_count' => DB::table('rewards')
                    ->selectRaw('count(id)')
                    ->whereColumn('skin_id', 'skins.id')
            ])
            ->addSelect([
                'reward_id' => DB::table('rewards')
                    ->select('reward_price_id')
                    ->whereColumn('skin_id', 'skins.id')
                    ->orderBy('reward_price_id','ASC')
                    ->take(1)
            ])
            ->addSelect([
                'second_reward_id' => DB::table('rewards')
                    ->select('reward_price_id')
                    ->whereColumn('skin_id', 'skins.id')
                    ->havingRaw('reward_price_id != reward_id')
                    ->orderBy('reward_price_id','ASC')
                    ->take(1)
            ])
            ->addSelect([
                'third_reward_id' => DB::table('rewards')
                    ->select('reward_price_id')
                    ->whereColumn('skin_id', 'skins.id')
                    ->havingRaw('reward_price_id != reward_id AND reward_price_id != second_reward_id')
                    ->orderBy('reward_price_id','ASC')
                    ->take(1)
            ])
            ->whereIn('id', $this->skinIds)
            ->get();

        $orderedSkins = collect($this->skinIds)->map(function ($id) use ($skins){
            return $skins->where('id', $id)->first();
        });

        return view('livewire.skin.skin-index-chunk', [
            'skins' => $orderedSkins,
        ]);
    }

    public function SwitchHeart($skin)
    {
        (new SwitchLikes)($skin);
    }
}
