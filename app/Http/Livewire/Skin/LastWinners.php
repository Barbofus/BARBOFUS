<?php

namespace App\Http\Livewire\Skin;

use App\Actions\Likes\SwitchLikes;
use App\Models\Reward;
use App\Models\Skin;
use Livewire\Component;

class LastWinners extends Component
{
    public $winners;

    public function mount()
    {
        $this->FetchLastWinners();
    }

    public function render()
    {
        return view('livewire.skin.last-winners', [
            'skins' => $this->winners
        ]);
    }

    public function FetchLastWinners()
    {
        for ($i = 0 ; $i <= 2; $i++) {
            $winner = Reward::query()
                ->with('Skin')
                ->where('reward_price_id', $i + 1)
                ->orderBy('created_at', 'DESC')
                ->pluck('skin_id')
                ->first();
            $this->winners[$i] = Skin::with('Likes', 'Rewards', 'User', 'Rewards.RewardPrice')->find($winner);
        }
    }

    public function SwitchHeart($skin)
    {
        (new SwitchLikes)($skin);
    }
}
