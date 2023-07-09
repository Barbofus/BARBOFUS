<?php

namespace App\Http\Livewire\UserPanel;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MylikesInfiniteLoad extends Component
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
        if (! $this->hasLoadMore) {
            $this->PrepareChunks();
        }

        return view('livewire.user-panel.mylikes-infinite-load');
    }

    public function LoadMore()
    {
        if ($this->HasMorePage()) {
            $this->page++;
            $this->hasLoadMore = true;
        }
    }

    public function PrepareChunks()
    {
        $this->postIdChunks = DB::table('skins')

            // select princpal
            ->select('skins.id')
            ->addSelect([
                'like_created_at' => DB::table('likes')->select('created_at')
                    ->where('likes.user_id', Auth::id())
                    ->whereColumn('likes.skin_id', 'skins.id')
                    ->orderBy('created_at')
                    ->take(1),
            ])

            // Seulement les skins que l'on a liké
            ->whereExists(function (Builder $query) {
                $query->select('id')
                    ->from('likes')
                    ->where('likes.user_id', Auth::id())
                    ->whereColumn('likes.skin_id', 'skins.id');
            })

            ->where('skins.status', 'Posted')

            // orderBy
            ->orderBy('like_created_at', 'DESC')

            // Scroll infini
            ->pluck('id')
            ->chunk(self::ITEMS_PER_PAGE)
            ->toArray();

        $this->page = 1;

        $this->maxPage = count($this->postIdChunks);

        $this->queryCount++;
    }

    public function HasMorePage()
    {
        return $this->page < $this->maxPage;
    }
}
