<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\Skins\DeleteSkin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class MyskinsInfiniteLoad extends Component
{
    public const ITEMS_PER_PAGE = 60;

    /**
     * @var array<int, int[]>
     */
    public $postIdChunks = [];

    public int $page = 1;

    public int $maxPage = 1;

    public int $queryCount = 0;

    protected bool $hasLoadMore = false;

    /**
     * @var string[]
     */
    protected $listeners = [
        'ReloadInfinite' => '$refresh',
    ];

    /**
     * @return View
     */
    public function render()
    {
        if (! $this->hasLoadMore) {
            $this->PrepareChunks();
        }

        return view('livewire.user-panel.myskins-infinite-load');
    }

    /**
     * @return void
     */
    public function deleteSkin(int $skinID)
    {
        (new DeleteSkin)($skinID);
    }

    /**
     * @return void
     */
    public function LoadMore()
    {
        if ($this->HasMorePage()) {
            $this->page++;
            $this->hasLoadMore = true;
        }
    }

    /**
     * @return void
     */
    public function PrepareChunks()
    {
        $this->postIdChunks = DB::table('skins')

            // select princpal
            ->select('skins.id')

            // Seulement les skins que l'on a liké
            ->where('user_id', Auth::id())

            // orderBy
            ->orderBy('status', 'DESC')
            ->orderBy('updated_at', 'DESC')

            // Scroll infini
            ->pluck('id')
            ->chunk(self::ITEMS_PER_PAGE)
            ->toArray();

        $this->page = 1;

        $this->maxPage = count($this->postIdChunks);

        $this->queryCount++;
    }

    /**
     * @return bool
     */
    public function HasMorePage()
    {
        return $this->page < $this->maxPage;
    }
}
