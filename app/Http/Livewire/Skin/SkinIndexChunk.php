<?php

namespace App\Http\Livewire\Skin;

use App\Models\Skin;
use Livewire\Component;

class SkinIndexChunk extends Component
{
    public $skinIds;
    public $page;
    public $itemsPerPage;

    public function render()
    {
        $skins = Skin::find($this->skinIds)->keyBy('id');

        $orderedSkins = collect($this->skinIds)->map(fn ($id) => $skins[$id]);
        $this->itemsPerPage = count($orderedSkins);

        return view('livewire.skin.skin-index-chunk', [
            'skins' => $orderedSkins,
        ]);
    }
}
