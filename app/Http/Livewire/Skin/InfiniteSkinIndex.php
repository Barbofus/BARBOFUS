<?php

namespace App\Http\Livewire\Skin;

use App\Models\Like;
use App\Models\Skin;
use Livewire\Component;
use Termwind\Components\Dd;

class InfiniteSkinIndex extends Component
{
    public const ITEMS_PER_PAGE = 20;

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
        'refresh-me' => '$refresh'
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
        $newFetch = Skin::where('status', '=', 'Posted')->withSum('Rewards', 'reward_value')->withCount(['Likes', 'Rewards'])->orderBy($this->orderBy, $this->orderDirection)->orderBy('updated_at', 'DESC')->skip(self::ITEMS_PER_PAGE * $this->currentPage)->take(self::ITEMS_PER_PAGE)->get();

        $this->skins = ($this->currentPage > 0) ? $this->skins->merge($newFetch) : $newFetch;

        $this->currentPage ++;
    }

    public function SortBy($orderBy, $orderDir)
    {
        $this->orderBy = $this->allOrder[$orderBy];
        $this->orderDirection = $orderDir;

        $this->currentPage = 0;

        $this->LoadMore();
    }

    public function SwitchHeart($skin)
    {
        // Si on a déjà like le skin
        foreach (Like::where('skin_id', '=', $skin)->where('user_id', '=', \Auth::user()->id)->get() as $like) {
            $like->delete();

            $this->emit('refresh-me');

            return;
        }

        // Sinon, ont le créé
        Like::create([
            'skin_id' => $skin,
            'user_id' => \Auth::user()->id
        ]);

        $this->emit('refresh-me');
    }
}
