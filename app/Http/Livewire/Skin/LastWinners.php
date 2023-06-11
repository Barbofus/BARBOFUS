<?php

namespace App\Http\Livewire\Skin;

use App\Actions\Likes\SwitchLikes;
use App\Models\Reward;
use App\Models\Skin;
use App\Models\SkinWinner;
use Illuminate\Support\Facades\DB;
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
        $this->winners = DB::table('skin_winners')
            ->orderBy('reward_id','DESC')
            ->get();
    }

    public function Refresh()
    {
        $this->dispatchBrowserEvent('skin-index-render');
    }
}
