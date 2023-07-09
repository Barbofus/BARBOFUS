<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\Likes\SwitchLikes;
use App\Actions\Skins\GetSkinChunk;
use Livewire\Component;

class MylikesChunk extends Component
{
    public $skinIds;

    public $page;

    public $itemsPerPage;

    public function render()
    {
        $orderedSkins = (new GetSkinChunk)($this->skinIds);

        return view('livewire.user-panel.mylikes-chunk', [
            'skins' => $orderedSkins,
        ]);
    }

    public function SwitchHeart($skin)
    {
        (new SwitchLikes)($skin);
        $this->emit('ReloadInfinite');
    }
}
