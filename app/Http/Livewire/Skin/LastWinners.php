<?php

namespace App\Http\Livewire\Skin;

use App\Actions\Likes\SwitchLikes;
use App\Models\Reward;
use App\Models\Skin;
use App\Models\SkinWinner;
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
        $this->winners = SkinWinner::query()
            ->orderBy('reward_id')
            ->get();
    }

    public function Refresh()
    {
        $this->dispatchBrowserEvent('skin-index-render');
    }
}
