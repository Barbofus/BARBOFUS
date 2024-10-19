<?php

namespace App\Http\Livewire\UnitySkin;

use App\Actions\Utils\DoColorsMatch;
use App\Models\Skin;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class InfiniteUnitySkinIndex extends Component
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
        'unity_skins.created_at',
        'likes_count',
        'rewards_points',
        'unity_skins.race_id',
        'tuesday_like_count',
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
        'dofus_item_wing',
        'dofus_item_shoulder',
    ];

    /**
     * @var string[]
     */
    protected $skinColors = [
        'color_cloth_1',
        'color_cloth_2',
        'color_cloth_3',
        'color_cloth_4',
    ];

    protected bool $hasLoadMore = false;

    public string $orderBy = 'unity_skins.created_at'; // Nouveauté par défault

    public int $orderByID = 0;

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

    /**
     * @var array<int, string>
     */
    public $skinPetTypeWhere = [];

    public bool $barbeOnly = false;

    public bool $winnersOnly = false;

    /**
     * @var array<int, string[]>
     */
    public $searchFilterInput = [];

    public string $filterColor = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'ToggleSearchedText',
        'ToggleRace',
    ];

    public function mount(): void
    {
        // Si on a des paramètres dans l'url
        if (request()->all()) {
            //dd(request()->all());
            foreach (request()->all() as $key => $param) {
                switch ($key) {
                    case 'color':
                        $this->updateFilterColor($param);
                        break;
                    case 'classe':
                        foreach (explode(',', $param) as $race_id) {
                            $this->ToggleRace(intval($race_id));
                        }
                        break;
                    case 'search':
                        foreach (explode(',', $param) as $searchKey => $searchedName) {
                            $this->ToggleSearchedText([urldecode($searchedName), explode(',', request()->input('searchID'))[$searchKey]]);
                        }
                        break;
                    case 'sort':
                        $values = explode(',', $param);
                        $this->SortBy(intval($values[0]), $values[1]);
                        //dd(explode(',', $param));
                        break;
                }
            }
        }
    }

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

        return view('livewire.unity-skin.infinite-unity-skin-index');
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
        $this->postIdChunks = DB::table('unity_skins')

            // Les joins
            ->join('users', 'unity_skins.user_id', '=', 'users.id')
            ->when(count($this->skinContentWhere) > 0 || count($this->searchFilterInput) > 0 || count($this->skinPetTypeWhere) > 0, function (Builder $query) {
                foreach ($this->itemRelations as $item) {
                    $tableItem = $item;

                    if ($item == 'dofus_item_shoulder' || $item == 'dofus_item_wing') {
                        if ($item == 'dofus_item_wing') {
                            $query->leftJoin('dofus_item_costumes as wings', 'wings.id', '=', 'unity_skins.dofus_item_wing_id');

                            continue;
                        }

                        $query->leftJoin('dofus_item_costumes as shoulders', 'shoulders.id', '=', 'unity_skins.dofus_item_shoulder_id');

                        continue;
                    }
                    $query->leftJoin($item.'s', $tableItem.'s.id', '=', 'unity_skins.'.$item.'_id');
                }
            })

            // select princpal
            ->select('unity_skins.id', 'unity_skins.user_id')

            ->when($this->skinColors != '', function (Builder $query) {
                foreach ($this->skinColors as $color) {
                    $query->addSelect('unity_skins.'.$color);
                }
            })

            // Variables utiles pour les orderBy
            ->addSelect([
                'rewards_points' => DB::table('unity_rewards')
                    ->selectRaw('sum(points)')
                    ->whereColumn('unity_rewards.unity_skin_id', 'unity_skins.id'),
            ])
            ->addSelect([
                'likes_count' => DB::table('unity_likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('unity_likes.unity_skin_id', 'unity_skins.id'),
            ])
            ->addSelect([
                'tuesday_like_count' => DB::table('unity_likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('unity_skin_id', 'unity_skins.id')
                    ->whereDate('created_at', '>', Carbon::today()->subWeek()->subDay()->toDateString()),
            ])

            // Début du système de filtres
            ->where($this->raceWhere)
            ->where($this->genderWhere)

            // Barbe Only
            ->when($this->barbeOnly, function (Builder $query) {
                $query->where('users.name', 'Barbe Douce');
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
                                    ->whereColumn($item.'s.id', 'unity_skins.'.$item.'_id');
                            })
                                ->orWhereNotIn($item.'s.dofus_items_sub_categorie_id', $this->skinContentWhere);
                        });

                    }
                });
            })

            // Skin pet type
            ->when(count($this->skinPetTypeWhere) > 0, function (Builder $query) {
                $query->where(function (Builder $query) {

                    $query->when(in_array('familier', $this->skinPetTypeWhere), function (Builder $query) {
                        $query->whereExists(function (Builder $query) {
                            $query->select('id')
                                ->from('dofus_item_pets')

                                ->whereColumn('dofus_item_pets.id', 'unity_skins.dofus_item_pet_id');
                        })
                            ->WhereNotIn('dofus_item_pets.type', $this->skinPetTypeWhere);
                    });

                    $query->when(! in_array('familier', $this->skinPetTypeWhere), function (Builder $query) {
                        $query->whereNotExists(function (Builder $query) {
                            $query->select('id')
                                ->from('dofus_item_pets')

                                ->whereColumn('dofus_item_pets.id', 'unity_skins.dofus_item_pet_id');
                        })
                            ->OrWhereNotIn('dofus_item_pets.type', $this->skinPetTypeWhere);
                    });
                });
            })

            // SearchBar x
            ->when(count($this->searchFilterInput) > 0, function (Builder $query) {
                $query->where(function (Builder $query) {

                    // Pour chaque mot clef
                    foreach ($this->searchFilterInput as $input) {

                        // Si le filtre 'Voir uniquement les skins de Barbe' n'est pas coché, alors on teste les pseudos
                        $query->orWhere('users.name', $input);

                        // ensuite, on teste les noms d'items, toujours en OR
                        foreach ($this->itemRelations as $item) {
                            $tableItem = $item;

                            if ($item == 'dofus_item_shoulder' || $item == 'dofus_item_wing') {
                                // Gestion des alias pour les ailes et les épaulettes
                                if ($item == 'dofus_item_wing') {
                                    $tableItem = 'wings';
                                }
                                if ($item == 'dofus_item_shoulder') {
                                    $tableItem = 'shoulders';
                                }

                                // Recherche avec les alias sur dofus_item_costumes
                                $query->orWhere(function (Builder $query) use ($tableItem, $input) {
                                    $query->where($tableItem.'.name', $input[0])
                                        ->where($tableItem.'.id', $input[1]);
                                });
                            } else {
                                // Pour les autres items (hat, cloak, etc.), on utilise la table normale
                                $query->orWhere(function (Builder $query) use ($item, $input) {
                                    $query->where($item.'s.name', $input[0])
                                        ->where($item.'s.id', $input[1]);
                                });
                            }
                        }
                    }
                });
            })

            ->where('unity_skins.status', 'Posted')

            // orderBy
            ->when(! $this->randSort, function (Builder $query) {
                $query->orderBy($this->orderBy, $this->orderDirection)
                    ->when($this->orderByID == 4, function (Builder $query) {
                        $query->orderBy('unity_skins.created_at', 'ASC');
                    })
                    ->when($this->orderByID != 4, function (Builder $query) {
                        $query->orderBy('unity_skins.created_at', 'DESC');
                    });
            })
            ->when($this->randSort, function (Builder $query) {
                $query->inRandomOrder();
            })

            // Récupère les ID
            ->pluck('id')
            ->toArray();

        // Si on a une couleur à filtrer
        if ($this->filterColor != '') {
            $toRemove = [];

            // On reprend tous les skins basé sur les précédents ID, et on select l'id + les couleurs
            $skins = DB::table('unity_skins')
                ->whereIn('id', $this->postIdChunks)
                ->select('id')
                ->when($this->skinColors != '', function (Builder $query) {
                    foreach ($this->skinColors as $color) {
                        $query->addSelect('unity_skins.'.$color);
                    }
                })->get()->toArray();

            // Pour chacun d'entre eux, on test le colormatch sur chaque couleur, s'il y en a au moins une de bonne on passe à la boucle suivant
            foreach ($skins as $skin) {
                foreach ($this->skinColors as $color) {
                    if ((new DoColorsMatch)($this->filterColor, $skin->$color)) {
                        continue 2;
                    }
                }

                // Sinon on ajoute dans le tableau des IDs à supprimer
                $toRemove[] = $skin->id;
            }

            // On supprime tous les IDs dont la couleur de match pas
            foreach ($toRemove as $rem) {
                if (($key = array_search($rem, $this->postIdChunks)) !== false) {
                    unset($this->postIdChunks[$key]);
                }
            }
        }

        // On chunk et on envoie !
        $this->postIdChunks = array_chunk($this->postIdChunks, self::ITEMS_PER_PAGE);

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
        if ($orderBy == count($this->allOrder)) { // Si on choisi aléatoire
            $this->randSort = true;
            $this->orderByID = $orderBy;
            $this->orderDirection = $orderDir;

            return;
        }

        $this->randSort = false;
        $this->orderBy = $this->allOrder[$orderBy];
        $this->orderByID = $orderBy;
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
     * @param  string|string[]  $petType
     * @return void
     */
    public function TogglePetType(string|array $petType)
    {
        if (is_array($petType)) {
            foreach ($petType as $pt) {
                // Si le subcategory est déjà exclu
                if (count($this->skinPetTypeWhere) > 0 && ($key = array_search($pt, $this->skinPetTypeWhere)) !== false) {
                    unset($this->skinPetTypeWhere[$key]);

                    continue;
                }

                $this->skinPetTypeWhere[] = $pt;
            }

            return;
        }
        // Si le subcategory est déjà exclu
        if (count($this->skinPetTypeWhere) > 0 && ($key = array_search($petType, $this->skinPetTypeWhere)) !== false) {
            unset($this->skinPetTypeWhere[$key]);

            return;
        }

        $this->skinPetTypeWhere[] = $petType;
    }

    /**
     * @return void
     */
    public function updateFilterColor(string $hex)
    {
        $hex = ltrim($hex, '#');
        $this->filterColor = $hex;
    }

    /**
     * @return void
     */
    public function resetFilterColor()
    {
        $this->filterColor = '';
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
     * @param  string|array<int, string>  $search
     * @return void
     */
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
