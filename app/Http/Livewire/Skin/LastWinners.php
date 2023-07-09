<?php

namespace App\Http\Livewire\Skin;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class LastWinners extends Component
{
    public mixed $winners;

    /**
     * @return View
     */
    public function render()
    {
        $this->FetchLastWinners();

        return view('livewire.skin.last-winners', [
            'skins' => $this->winners,
        ]);
    }

    /**
     * @return void
     */
    public function FetchLastWinners()
    {
        $this->winners = DB::table('skin_winners')
            ->orderBy('reward_id', 'DESC')
            ->get();
    }

    /**
     * @return void
     */
    public function Refresh()
    {
        $this->dispatchBrowserEvent('skin-index-render');
    }
}
