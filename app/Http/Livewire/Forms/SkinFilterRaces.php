<?php

namespace App\Http\Livewire\Forms;

use Illuminate\View\View;
use Livewire\Component;

class SkinFilterRaces extends Component
{
    public mixed $races;

    /**
     * @var array<int, string[]>
     */
    public $raceWhere;

    /**
     * @return View
     */
    public function render()
    {
        return view('livewire.forms.skin-filter-races');
    }
}
