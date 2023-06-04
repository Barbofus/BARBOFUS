<?php

namespace App\Http\Livewire\Skin;

use App\Models\Like;
use App\Models\Race;
use App\Models\Reward;
use App\Models\RewardPrice;
use App\Models\Skin;
use DateTime;
use Livewire\Component;
use Termwind\Components\Dd;

class InfiniteSkinIndex extends Component
{
    public const ITEMS_PER_PAGE = 60;

    public $postIdChunks = [];
    public $page = 1;
    public $maxPage = 1;
    public $queryCount = 0;
    protected $allOrder = [
        'updated_at',
        'Likes_count',
        'Rewards_sum_points',
    ];
    public $orderBy = 'updated_at'; // Nouveauté par défault
    public $orderDirection = 'DESC';
    protected $listeners = [
        'load-more' => 'LoadMore',
    ];


    public function mount()
    {
        $this->PrepareChunks();
    }
    public function render()
    {
        $this->dispatchBrowserEvent('skin-index-render');
        return view('livewire.skin.infinite-skin-index');
    }

    public function LoadMore()
    {
        if($this->HasMorePage()) {
            $this->page ++;
        }
    }

    public function PrepareChunks()
    {
        $this->postIdChunks = Skin::query()
            ->select('id')
            ->where('status', 'Posted')
            /*->where([])
            ->Where([['gender', 'Homme', 'or']])
            ->Where([['race_id', '=', '1', 'or'], ['race_id', '=', '19', 'or']])*/
            ->withSum('Rewards', 'points')
            ->withCount('Likes')
            ->orderBy($this->orderBy, $this->orderDirection)
            ->orderBy('updated_at', 'DESC')
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

    public function SortBy($orderBy, $orderDir)
    {
        $this->orderBy = $this->allOrder[$orderBy];
        $this->orderDirection = $orderDir;

        $this->PrepareChunks();
    }
}
