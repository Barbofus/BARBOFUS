<?php

namespace App\Http\Livewire\Skin;

use App\Models\Skin;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

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

    protected $itemRelations = [
        'DofusItemHat',
        'DofusItemCloak',
        'DofusItemShield',
        'DofusItemPet',
        'DofusItemCostume',
    ];
    protected $hasLoadMore = false;

    public $orderBy = 'updated_at'; // Nouveauté par défault
    public $orderDirection = 'DESC';

    public $races;

    public $raceWhere = array();
    public $genderWhere = array();
    public $skinContentWhere = array();
    public $barbeOnly = false;
    public $winnersOnly = false;
    public $searchFilterInput = array();

    protected $listeners = [
        'ToggleSearchedText',
    ];


    public function render()
    {
        $this->races = DB::table('races')->get();

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

            // Barbe Only
            ->when($this->barbeOnly, function (Builder $query) {
                $query->whereRelation('User', 'name', '=', 'Barbe Douce');
            })

            // Winners Only
            ->when($this->winnersOnly, function (Builder $query) {
                $query->whereHas('Rewards');
            })

            // Skin content
            ->when(count($this->skinContentWhere) > 0, function (Builder $query) {
                $query->where(function (Builder $query) {

                    // Parcous toutes les relations d'items (DofusItemHat etc..)
                    foreach ($this->itemRelations as $relation) {
                        $query->where(function (Builder $query) use ($relation) {
                            $query->doesntHave($relation)
                                ->orWhereRelation($relation, $this->skinContentWhere);
                        });
                    }
                });
            })

            // SearchBar
            ->when(count($this->searchFilterInput) > 0, function (Builder $query) {
                $query->where(function (Builder $query) {

                    // Pour chaque mot clef
                    foreach ($this->searchFilterInput as $input) {

                        // Si le filtre 'Voir uniquement les skins de Barbe' n'est pas coché, alors on teste les pseudos
                        $query->orWhereRelation('User', 'name', 'LIKE', '%' . $input . '%');

                        // ensuite, on teste les noms d'items, toujours en OR
                        foreach ($this->itemRelations as $relation) {
                            $query->orWhereRelation($relation, 'name', 'LIKE', '%' . $input . '%');
                        }
                    }
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
        if (count($this->genderWhere) > 0 && ($key = array_search(['gender', '!=', $gender], $this->genderWhere)) !== false) {
            unset($this->genderWhere[$key]);
            return;
        }

        $this->genderWhere[] = ['gender', '!=', $gender];
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

    public function ToggleShowBarbeOnly()
    {
        $this->barbeOnly = !$this->barbeOnly;
    }

    public function ToggleShowWinnersOnly()
    {
        $this->winnersOnly = !$this->winnersOnly;
    }

    public function ToggleSearchedText($search)
    {
        // Si le mot clef est déjà dans le tableau, on le retire
        if (count($this->searchFilterInput) > 0 && ($key = array_search($search, $this->searchFilterInput)) !== false) {
            unset($this->searchFilterInput[$key]);
            return;
        }

        $this->searchFilterInput[] = $search;
    }
}
