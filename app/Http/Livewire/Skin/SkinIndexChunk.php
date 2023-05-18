<?php

namespace App\Http\Livewire\Skin;

use App\Actions\Likes\SwitchLikes;
use App\Models\Like;
use App\Models\Skin;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SkinIndexChunk extends Component
{
    public $skinIds;
    public $page;
    public $itemsPerPage;

    public function render()
    {
        $skins = Skin::query()
            ->with('Likes', 'Rewards', 'User', 'Rewards.RewardPrice')
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
