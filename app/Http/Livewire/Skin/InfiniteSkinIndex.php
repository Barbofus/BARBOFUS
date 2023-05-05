<?php

namespace App\Http\Livewire\Skin;

use App\Models\Skin;
use Livewire\Component;
use Termwind\Components\Dd;

class InfiniteSkinIndex extends Component
{
    const ITEMS_PER_PAGE = 6;

    public $skins;
    public $currentPage = 0;
    public $orderBy = 'updated_at';
    public $orderDirection = 'desc';
    protected $listeners = [
        'load-more' => 'LoadMore'
    ];

    public function mount()
    {
        $this->LoadMore();
    }
    public function render()
    {
        return view('livewire.skin.infinite-skin-index');
    }

    public function LoadMore()
    {
        $newFetch = Skin::where('status', '=', 'Posted')->orderBy($this->orderBy, $this->orderDirection)->skip(self::ITEMS_PER_PAGE * $this->currentPage)->take(self::ITEMS_PER_PAGE)->get();

        $this->skins = ($this->currentPage > 0) ? $this->skins->merge($newFetch) : $newFetch;

        $this->currentPage ++;
    }

    public function SortByID()
    {
        $this->orderBy = 'id';
        $this->orderDirection = 'asc';

        $this->currentPage = 0;

        $this->LoadMore();
    }
}
