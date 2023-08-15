<?php

namespace App\Http\Livewire\Skin;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class InfiniteSkinIndex extends Component
{
    public const ITEMS_PER_PAGE = 60;

    /**
     * @var array<int, int[]>
     */
    public $postIdChunks = [];

    public int $page = 1;

    public int $maxPage = 1;

    public int $queryCount = 0;

    /**
     * @var string[]
     */
    protected $allOrder = [
        'skins.updated_at',
        'likes_count',
        'rewards_points',
        'skins.race_id',
    ];


    /**
     * @var string[]
     */
    protected $itemRelations = [
        'dofus_item_hat',
        'dofus_item_cloak',
        'dofus_item_shield',
        'dofus_item_pet',
        'dofus_item_costume',
    ];

    protected bool $hasLoadMore = false;

    public string $orderBy = 'skins.updated_at'; // Nouveauté par défault
    public bool $randSort = false; // Trié aléatoirement par défault

    public string $orderDirection = 'DESC';

    public mixed $races;

    /**
     * @var array<int, string[]>
     */
    public $raceWhere = [];

    /**
     * @var array<int, string[]>
     */
    public $genderWhere = [];

    /**
     * @var array<int, string[]>
     */
    public $skinContentWhere = [];

    public bool $barbeOnly = false;

    public bool $winnersOnly = false;

    /**
     * @var array<int, string[]>
     */
    public $searchFilterInput = [];

    /**
     * @var string[]
     */
    protected $listeners = [
        'ToggleSearchedText',
    ];

    /**
     * @return View
     */
    public function render()
    {
        $this->races = DB::table('races')->get();

        if (! $this->hasLoadMore) {
            $this->PrepareChunks();
        }

        $this->dispatchBrowserEvent('skin-index-render');

        return view('livewire.skin.infinite-skin-index');
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

            // Les joins
            ->join('users', 'skins.user_id', '=', 'users.id')
            ->when(count($this->skinContentWhere) > 0 || count($this->searchFilterInput) > 0, function (Builder $query) {
                foreach ($this->itemRelations as $item) {
                    $query->leftJoin($item.'s', $item.'s.id', '=', 'skins.'.$item.'_id');
                }
            })

            // select princpal
            ->select('skins.id')

            // Variables utiles pour les orderBy
            ->addSelect([
                'rewards_points' => DB::table('rewards')
                    ->selectRaw('sum(points)')
                    ->whereColumn('rewards.skin_id', 'skins.id'),
            ])
            ->addSelect([
                'likes_count' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('likes.skin_id', 'skins.id'),
            ])

            // Début du système de filtres
            ->where($this->raceWhere)
            ->where($this->genderWhere)

            // Barbe Only
            ->when($this->barbeOnly, function (Builder $query) {
                $query->where('users.name', 'Barbe Douce');
            })

            // Winners Only
            ->when($this->winnersOnly, function (Builder $query) {
                $query->whereExists(function (Builder $query) {
                    $query->select('id')
                        ->from('rewards')
                        ->whereColumn('rewards.skin_id', 'skins.id');
                });
            })

            // Skin content
            ->when(count($this->skinContentWhere) > 0, function (Builder $query) {
                $query->where(function (Builder $query) {

                    // Parcous toutes les relations d'items (DofusItemHat etc..)
                    foreach ($this->itemRelations as $item) {
                        $query->where(function (Builder $query) use ($item) {

                            $query->whereNotExists(function (Builder $query) use ($item) {
                                $query->select('id')
                                    ->from($item.'s')
                                    ->whereColumn($item.'s.id', 'skins.'.$item.'_id');
                            })
                                ->orWhereNotIn($item.'s.dofus_items_sub_categorie_id', $this->skinContentWhere);
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
                        $query->orWhere('users.name', $input);
                    }

                    // ensuite, on teste les noms d'items, toujours en OR
                    foreach ($this->itemRelations as $item) {
                        $query->orWhereIn($item.'s.name', $this->searchFilterInput);
                    }
                });
            })

            ->where('skins.status', 'Posted')

            // orderBy
            ->when(!$this->randSort, function (Builder $query) {
                $query->orderBy($this->orderBy, $this->orderDirection)
                ->orderBy('skins.updated_at', 'DESC');
            })
            ->when($this->randSort, function (Builder $query) {
                $query->inRandomOrder();
            })

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

    /**
     * @return void
     */
    public function SortBy(int $orderBy, string $orderDir)
    {
        if($orderBy == 4) { // Si on choisi aléatoire
            $this->randSort = true;
            return;
        }

        $this->randSort = false;
        $this->orderBy = $this->allOrder[$orderBy];
        $this->orderDirection = $orderDir;
    }

    /**
     * @return void
     */
    public function ToggleRace(int $raceID)
    {
        // Si la classe est déjà selectionné
        if (count($this->raceWhere) > 0 && ($key = array_search(['race_id', '=', $raceID, 'or'], $this->raceWhere)) !== false) {
            unset($this->raceWhere[$key]);

            return;
        }

        $this->raceWhere[] = ['race_id', '=', $raceID, 'or'];
    }

    /**
     * @return void
     */
    public function UnselectAllRaces()
    {
        $this->raceWhere = [];
    }

    /**
     * @return void
     */
    public function ToggleGender(string $gender)
    {
        // Si le genre est déjà selectionné
        if (count($this->genderWhere) > 0 && ($key = array_search(['gender', '!=', $gender], $this->genderWhere)) !== false) {
            unset($this->genderWhere[$key]);

            return;
        }

        $this->genderWhere[] = ['gender', '!=', $gender];
    }

    /**
     * @return void
     */
    public function ToggleSkinContent(int $subcategoryID)
    {
        // Si le subcategory est déjà exclu
        if (count($this->skinContentWhere) > 0 && ($key = array_search($subcategoryID, $this->skinContentWhere)) !== false) {
            unset($this->skinContentWhere[$key]);

            return;
        }

        $this->skinContentWhere[] = $subcategoryID;
    }

    /**
     * @return void
     */
    public function ToggleShowBarbeOnly()
    {
        $this->barbeOnly = ! $this->barbeOnly;
    }

    /**
     * @return void
     */
    public function ToggleShowWinnersOnly()
    {
        $this->winnersOnly = ! $this->winnersOnly;
    }

    /**
     * @return void
     */
    public function ToggleSearchedText(string $search)
    {
        // Si le mot clef est déjà dans le tableau, on le retire
        if (count($this->searchFilterInput) > 0 && ($key = array_search($search, $this->searchFilterInput)) !== false) {
            unset($this->searchFilterInput[$key]);

            return;
        }

        $this->searchFilterInput[] = $search;
    }
}
