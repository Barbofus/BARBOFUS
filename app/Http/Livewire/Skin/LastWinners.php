<?php

namespace App\Http\Livewire\Skin;

use App\Actions\Likes\SwitchLikes;
use App\Models\Reward;
use App\Models\Skin;
use Livewire\Component;

class LastWinners extends Component
{
    public $winners;


    public function render()
    {
        $this->FetchLastWinners();

        return view('livewire.skin.last-winners', [
            'skins' => $this->winners
        ]);
    }

    public function FetchLastWinners()
    {
        $winners = Reward::query()
            ->orderBy('created_at','DESC')
            ->orderBy('reward_price_id', 'ASC')
            ->pluck('skin_id')
            ->take(3)->toArray();

        $skins = Skin::query()
            ->with('Likes', 'Rewards', 'User', 'Rewards.RewardPrice')
            ->find($winners)
            ->keyBy('id');

        $this->winners = collect($winners)->map(fn ($id) => $skins[$id]);
    }

    public function SwitchHeart($skin)
    {
        (new SwitchLikes)($skin);
    }
}
