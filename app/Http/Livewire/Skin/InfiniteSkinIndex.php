<?php

namespace App\Http\Livewire\Skin;

use App\Models\Like;
use App\Models\Race;
use App\Models\Reward;
use App\Models\RewardPrice;
use App\Models\Skin;
use DateTime;
use Illuminate\Contracts\Database\Eloquent\Builder;
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

    protected $hasLoadMore = false;

    public $orderBy = 'updated_at'; // Nouveauté par défault
    public $orderDirection = 'DESC';

    public $races;

    public $raceWhere = array();
    public $genderWhere = array();
    public $skinContentWhere = array();

    protected $listeners = [
        'load-more' => 'LoadMore',
    ];


    public function mount()
    {
        $this->races = Race::all();

        $this->ToggleGender('Femme');
        $this->ToggleGender('Homme');
    }
    public function render()
    {
        if(!$this->hasLoadMore) $this->PrepareChunks();
        $this->dispatchBrowserEvent('skin-index-render');
        return view('livewire.skin.infinite-skin-index');
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
        $this->postIdChunks = Skin::query()
            ->select('id')
            ->where('status', 'Posted')

            // Variables utiles pour les orderBy
            ->withSum('Rewards', 'points')
            ->withCount('Likes')

            // Début du système de filtres
            ->where($this->raceWhere)
            ->where($this->genderWhere)

            // Filtres en lien avec les items
            ->where(function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query  ->doesntHave('DofusItemHat')
                            ->orWhereRelation('DofusItemHat', $this->skinContentWhere);
                });
                $query->where(function (Builder $query) {
                    $query  ->doesntHave('DofusItemCloak')
                            ->orWhereRelation('DofusItemCloak', $this->skinContentWhere);
                });
                $query->where(function (Builder $query) {
                    $query  ->doesntHave('DofusItemShield')
                            ->orWhereRelation('DofusItemShield', $this->skinContentWhere);
                });
                $query->where(function (Builder $query) {
                    $query  ->doesntHave('DofusItemPet')
                            ->orWhereRelation('DofusItemPet', $this->skinContentWhere);
                });
                $query->where(function (Builder $query) {
                    $query  ->doesntHave('DofusItemCostume')
                            ->orWhereRelation('DofusItemCostume', $this->skinContentWhere);
                });
            })

            // orderBy
            ->orderBy($this->orderBy, $this->orderDirection)
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

    public function SortBy($orderBy, $orderDir)
    {
        $this->orderBy = $this->allOrder[$orderBy];
        $this->orderDirection = $orderDir;
    }

    public function ToggleRace($raceID)
    {
        // Si la classe est déjà selectionné
        if (count($this->raceWhere) > 0 && ($key = array_search(['race_id', '=', $raceID, 'or'], $this->raceWhere)) !== false) {
            unset($this->raceWhere[$key]);
            return;
        }

        $this->raceWhere[] = ['race_id', '=', $raceID, 'or'];
    }

    public function UnselectAllRaces()
    {
        $this->raceWhere = array();
    }

    public function ToggleGender($gender)
    {
        // Si le genre est déjà selectionné
        if (count($this->genderWhere) > 0 && ($key = array_search(['gender', '=', $gender, 'or'], $this->genderWhere)) !== false) {
            unset($this->genderWhere[$key]);
            return;
        }

        $this->genderWhere[] = ['gender', '=', $gender, 'or'];
    }

    public function ToggleSkinContent($subcategoryID)
    {
        // Si le subcategory est déjà exclu
        if (count($this->skinContentWhere) > 0 && ($key = array_search(['dofus_items_sub_categorie_id', '!=', $subcategoryID], $this->skinContentWhere)) !== false) {
            unset($this->skinContentWhere[$key]);
            return;
        }

        $this->skinContentWhere[] = ['dofus_items_sub_categorie_id', '!=', $subcategoryID];
    }
}
