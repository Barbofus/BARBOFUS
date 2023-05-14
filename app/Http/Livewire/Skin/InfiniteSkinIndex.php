<?php

namespace App\Http\Livewire\Skin;

use App\Models\Like;
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

    public $skins;
    public $currentPage = 0;
    protected $allOrder = [
        'updated_at',
        'Likes_count',
        'Rewards_sum_reward_value',
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
        return view('livewire.skin.infinite-skin-index');
    }

    public function LoadMore()
    {
        if($this->HasMorePage()) {
            $this->page ++;
        }
    }

    /*public function LoadMore()
    {
        $newFetch = Skin::where('status', '=', 'Posted')->withSum('Rewards', 'reward_value')->withCount(['Likes', 'Rewards'])->orderBy($this->orderBy, $this->orderDirection)->orderBy('updated_at', 'DESC')->skip(self::ITEMS_PER_PAGE * $this->currentPage)->take(self::ITEMS_PER_PAGE)->get();

        $this->skins = ($this->currentPage > 0) ? $this->skins->merge($newFetch) : $newFetch;

        $this->currentPage ++;
    }*/

    public function PrepareChunks()
    {
        $this->postIdChunks = Skin::where('status', '=', 'Posted')->withSum('Rewards', 'reward_value')->withCount(['Likes', 'Rewards'])->orderBy($this->orderBy, $this->orderDirection)->orderBy('updated_at', 'DESC')->pluck('id')->chunk(self::ITEMS_PER_PAGE)->toArray();

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

        /*$this->currentPage = 0;

        $this->LoadMore();*/

        $this->PrepareChunks();
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
