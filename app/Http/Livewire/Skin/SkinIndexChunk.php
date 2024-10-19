<?php

namespace App\Http\Livewire\Skin;

use App\Actions\Likes\SwitchLikes;
use App\Actions\Skins\GetSkinChunk;
use Illuminate\View\View;
use Livewire\Component;

class SkinIndexChunk extends Component
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

        return view('livewire.skin.skin-index-chunk', [
            'skins' => $orderedSkins,
        ]);
    }

    /**
     * @return void
     */
    public function SwitchHeart(int $skinID)
    {
        (new SwitchLikes)($skinID, false);
    }
}
