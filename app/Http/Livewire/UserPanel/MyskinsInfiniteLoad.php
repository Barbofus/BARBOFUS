<?php

namespace App\Http\Livewire\UserPanel;

use App\Models\Skin;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MyskinsInfiniteLoad extends Component
{
    public const ITEMS_PER_PAGE = 60;

    public $postIdChunks = [];
    public $page = 1;
    public $maxPage = 1;
    public $queryCount = 0;

    protected $hasLoadMore = false;

    protected $listeners = [
        'ReloadInfinite' => '$refresh',
    ];


    public function render()
    {
        if(!$this->hasLoadMore) $this->PrepareChunks();

        return view('livewire.user-panel.myskins-infinite-load');
    }

    public function deleteSkin($skinID)
    {
        Skin::find($skinID)->delete();
    }

    public function LoadMore()
    {
        if($this->HasMorePage()) {
            $this->page ++;
            $this->hasLoadMore = true;
        }
    }

    public function PrepareChunks()
    {
        $this->postIdChunks = DB::table('skins')

            // select princpal
            ->select('skins.id')

            // Seulement les skins que l'on a liké
            ->where('user_id', Auth::id())

            ->where('skins.status', 'Posted')

            // orderBy
            ->orderBy('updated_at', 'DESC')

            // Scroll infini
            ->pluck('id')
            ->chunk(self::ITEMS_PER_PAGE)
            ->toArray();

        $this->page = 1;

        $this->maxPage = count($this->postIdChunks);

        $this->queryCount ++;
    }

    public function HasMorePage()
    {
        return $this->page < $this->maxPage;
    }
}
