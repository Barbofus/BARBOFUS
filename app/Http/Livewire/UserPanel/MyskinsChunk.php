<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\Skins\GetSkinChunk;
use Illuminate\View\View;
use Livewire\Component;

class MyskinsChunk extends Component
{
    /**
     * @var int[]
     */
    public $skinIds;

    public int $page;

    public int $itemsPerPage;

    /**
     * @return View
     */
    public function render()
    {
        $orderedSkins = (new GetSkinChunk)($this->skinIds);

        return view('livewire.user-panel.myskins-chunk', [
            'skins' => $orderedSkins,
        ]);
    }
}
