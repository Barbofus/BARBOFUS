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
            ->join('skins', 'skin_winners.skin_id', '=', 'skins.id')
            ->addSelect([
                'race_name' => DB::table('races')
                    ->select('name')
                    ->whereColumn('id', 'skins.race_id')
                    ->take(1),
            ])
            ->addSelect([
                'user_id' => DB::table('users')
                    ->select('id')
                    ->whereColumn('id', 'skins.user_id')
                    ->take(1),
            ])
            ->orderBy('reward_id', 'ASC')
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
