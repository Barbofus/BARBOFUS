<?php

namespace App\Http\Livewire\Skin;

use App\Actions\Likes\SwitchLikes;
use App\Actions\Skins\GetSkinChunk;
use Livewire\Component;

class SkinIndexChunk extends Component
{
    public $skinIds;

    public $page;

    public $itemsPerPage;

    public function render()
    {
        $orderedSkins = (new GetSkinChunk)($this->skinIds);

        return view('livewire.skin.skin-index-chunk', [
            'skins' => $orderedSkins,
        ]);
    }

    public function SwitchHeart($skin)
    {
        (new SwitchLikes)($skin);
    }
}
