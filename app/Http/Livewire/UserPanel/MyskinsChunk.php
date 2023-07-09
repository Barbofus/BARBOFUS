<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\Skins\GetSkinChunk;
use Livewire\Component;

class MyskinsChunk extends Component
{
    public $skinIds;

    public $page;

    public $itemsPerPage;

    public function render()
    {
        $orderedSkins = (new GetSkinChunk)($this->skinIds);

        return view('livewire.user-panel.myskins-chunk', [
            'skins' => $orderedSkins,
        ]);
    }
}
