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
                'reward_id' => DB::table('rewards')
                    ->select('rank')
                    ->whereColumn('skin_id', 'skins.id')
                    ->orderBy('rank','ASC')
                    ->take(1)
            ])
            ->addSelect([
                'second_reward_id' => DB::table('rewards')
                    ->select('rank')
                    ->whereColumn('skin_id', 'skins.id')
                    ->orderBy('rank','ASC')
                    ->skip(1)
                    ->take(1)
            ])
            ->addSelect([
                'third_reward_id' => DB::table('rewards')
                    ->select('rank')
                    ->whereColumn('skin_id', 'skins.id')
                    ->orderBy('rank','ASC')
                    ->skip(2)
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
