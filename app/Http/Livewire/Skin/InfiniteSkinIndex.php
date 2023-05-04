<?php

namespace App\Http\Livewire\Skin;

use App\Models\Skin;
use Livewire\Component;
use Termwind\Components\Dd;

class InfiniteSkinIndex extends Component
{
    const ITEMS_PER_PAGE = 20;

    public $skins;
    public $currentPage = 0;
    public $orderBy = 'updated_at';
    public $orderDirection = 'desc';

    public function mount()
    {
        $this->InitLoad();
    }
    public function render()
    {
        return view('livewire.skin.infinite-skin-index');
    }

    function InitLoad()
    {
        $this->currentPage = 0;

        $this->skins = Skin::where('status', '=', 'Posted')->orderBy($this->orderBy, $this->orderDirection)->skip(self::ITEMS_PER_PAGE * $this->currentPage)->take(self::ITEMS_PER_PAGE)->get();
    }

    public function LoadMore()
    {
        $this->currentPage ++;

        $newFetch = Skin::where('status', '=', 'Posted')->orderBy($this->orderBy)->skip(self::ITEMS_PER_PAGE * $this->currentPage)->take(self::ITEMS_PER_PAGE)->get();

        $this->skins = $this->skins->merge($newFetch);
    }

    public function SortByID()
    {
        $this->orderBy = 'id';
        $this->orderDirection = 'asc';


        $this->InitLoad();
    }
}
