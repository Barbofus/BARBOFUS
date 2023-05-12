<?php

namespace App\Http\Livewire\Skin;

use App\Models\Skin;
use Livewire\Component;
use Termwind\Components\Dd;

class InfiniteSkinIndex extends Component
{
    public const ITEMS_PER_PAGE = 20;

    public $skins;
    public $currentPage = 0;
    public $orderBy = 'updated_at'; // Nouveauté par défault
    public $orderDirection = 'DESC';
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

    public function SortBy($orderBy, $orderDir)
    {
        $this->orderBy = $orderBy;
        $this->orderDirection = $orderDir;

        $this->currentPage = 0;

        $this->LoadMore();
    }
}
