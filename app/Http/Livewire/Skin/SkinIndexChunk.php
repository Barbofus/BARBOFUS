<?php

namespace App\Http\Livewire\Skin;

use App\Models\Like;
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

        return view('livewire.skin.skin-index-chunk', [
            'skins' => $orderedSkins,
        ]);
    }

    public function SwitchHeart($skin)
    {
        // Si on a déjà like le skin
        foreach (Like::where('skin_id', '=', $skin)->where('user_id', '=', \Auth::user()->id)->get() as $like) {
            $like->delete();
            return;
        }

        // Sinon, ont le créé
        Like::create([
            'skin_id' => $skin,
            'user_id' => \Auth::user()->id
        ]);
    }
}
