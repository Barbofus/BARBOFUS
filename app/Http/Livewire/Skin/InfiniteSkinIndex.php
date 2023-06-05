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
        'race_id',
    ];
    public $orderBy = 'updated_at'; // Nouveauté par défault
    public $orderDirection = 'DESC';

    public $races;

    public $raceWhere = array();

    protected $listeners = [
        'load-more' => 'LoadMore',
    ];


    public function mount()
    {
        $this->races = Race::all();
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
            ->where($this->raceWhere)
            /*->Where([['gender', 'Homme', 'or']])
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

    public function ToggleRace($raceID)
    {
        // Si la classe est déjà selectionné
        if (count($this->raceWhere) > 0 && ($key = array_search(['race_id', '=', $raceID, 'or'], $this->raceWhere)) !== false) {
            unset($this->raceWhere[$key]);
            $this->PrepareChunks();
            return;
        }

        $this->raceWhere[] = ['race_id', '=', $raceID, 'or'];
        $this->PrepareChunks();
    }

    public function UnselectAllRaces()
    {
        $this->raceWhere = array();
        $this->PrepareChunks();
    }
}
