<?php

namespace App\Http\Livewire\Skin;

use App\Actions\Likes\SwitchLikes;
use App\Models\Like;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SkinIndexChunk extends Component
{
    public $skinIds;
    public $page;
    public $itemsPerPage;

    public function render()
    {
        $skins = Skin::select('id', 'image_path', 'created_at', 'gender', 'race_id', 'user_id')
            ->addSelect([
                'user_name' => User::select('name')
                    ->whereColumn('id', 'skins.user_id')
                    ->take(1)
            ])
            ->addSelect([
                'is_liked' => Like::select('id')
                    ->whereColumn('skin_id', 'skins.id')
                    ->where('user_id', Auth::id())
                    ->take(1)
            ])
            ->with( 'Rewards:reward_price_id', 'Rewards.RewardPrice', 'Race:name,id')
            ->withCount('Likes')
            ->find($this->skinIds)
            ->keyBy('id');

        $orderedSkins = collect($this->skinIds)->map(fn ($id) => $skins[$id]);

        return view('livewire.skin.skin-index-chunk', [
            'skins' => $orderedSkins,
        ]);
    }

    public function SwitchHeart($skin)
    {
        (new SwitchLikes)($skin);
    }
}
