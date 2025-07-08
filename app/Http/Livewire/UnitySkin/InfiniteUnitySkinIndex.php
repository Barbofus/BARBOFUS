<?php

namespace App\Http\Livewire\UnitySkin;

use App\Actions\Utils\DoColorsMatch;
use App\Enums\ItemSubcategorieEnum;
use App\Models\Race;
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

    public int $skinCount = 0;

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
    protected $itemCategory = [
        'hat',
        'cape',
        'shield',
        'pet',
        'costume',
        'wings',
        'shoulderpads',
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
     * @var array<int, array<int|string>>
     */
    public $raceWhere = [];

    /**
     * @var array<int, string[]>
     */
    public $genderWhere = [];

    /**
     * @var array<int, array<string>|string>
     */
    public $skinContentWhere = [];

    /**
     * @var array<int, string>
     */
    public $skinPetTypeWhere = [];

    public bool $barbeOnly = false;

    public bool $winnersOnly = false;

    /**
     * @var array<int, string>
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
        $breedIds = Race::all()->pluck('dofus_id')->toArray();

        // Si on a des paramètres dans l'url
        if (request()->all()) {
            foreach (request()->all() as $key => $param) {
                switch ($key) {
                    case 'color':
                        $this->updateFilterColor($param);
                        break;
                    case 'classe':
                        foreach (explode(',', $param) as $race_id) {
                            if(!in_array(intval($race_id), $breedIds)) {
                                continue;
                            }

                            $this->ToggleRace(intval($race_id));
                        }
                        break;
                    case 'search':
                        foreach (explode(',', $param) as $searchKey => $searchedName) {
                            $this->ToggleSearchedText($searchedName);
                        }
                        break;
                    case 'sort':
                        $values = explode(',', $param);
                        $this->SortBy(intval($values[0]), $values[1]);
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
        $this->races = DB::table('races')
            ->addSelect([
                'localized_name' => DB::table('localized_races')
                    ->select('name')
                    ->where('locale', app()->getLocale())
                    ->whereColumn('races.dofus_id', 'localized_races.dofus_id')
                    ->take(1),
            ])->get();

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
            /*->when(count($this->skinContentWhere) > 0 || count($this->searchFilterInput) > 0 || count($this->skinPetTypeWhere) > 0, function (Builder $query) {
                foreach ($this->itemCategory as $category) {
                    $query->leftJoin('items as '. $category .'_items', 'items.dofus_id', '=', 'unity_skins.'.$category.'_id');
                }
            })*/

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

            // Winners Only
            ->when($this->winnersOnly, function (Builder $query) {
                $query->whereExists(function (Builder $query) {
                    $query->select('id')
                        ->from('unity_rewards')
                        ->whereColumn('unity_rewards.unity_skin_id', 'unity_skins.id');
                });
            })

            // Skin content
            ->when(count($this->skinContentWhere) > 0, function (Builder $query) {
                $query->where(function (Builder $query) {

                    // Parcous toutes les catégories, et récupère le skin si les items correspondent au filtre, ou sont vides
                    foreach ($this->itemCategory as $category) {
                        $query->where(function (Builder $query) use ($category) {

                            $query->whereNotExists(function (Builder $query) use ($category) {
                                $query->select('dofus_id')
                                    ->from('items')
                                    ->whereColumn('items.dofus_id', 'unity_skins.'.$category.'_id');
                            })
                                ->orWhereExists(function (Builder $query) use ($category) {
                                    $query->select('dofus_id')
                                        ->from('items')
                                        ->whereColumn('items.dofus_id', 'unity_skins.'.$category.'_id')
                                        ->whereNotIn('items.subcategory', $this->skinContentWhere);
                                });
                        });

                    }
                });
            })

            // Skin pet type
            ->when(count($this->skinPetTypeWhere) > 0, function (Builder $query) {

                // Affiche uniquement ce qui est encore coché
                $query->when(count($this->skinPetTypeWhere) > 0 && count($this->skinPetTypeWhere) < 5, function (Builder $query) {
                    $query->whereExists(function (Builder $query) {
                        $query->select('dofus_id')
                            ->from('items')
                            ->whereColumn('items.dofus_id', 'unity_skins.pet_id')
                            ->WhereNotIn('items.pet_type', $this->skinPetTypeWhere);
                    });
                });

                // Si tout est déoché, on affiche que les skins sans familier / montiler / monture
                $query->when(count($this->skinPetTypeWhere) == 5, function (Builder $query) {
                    $query->whereNotExists(function (Builder $query) {
                        $query->select('dofus_id')
                            ->from('items')
                            ->whereColumn('items.dofus_id', 'unity_skins.pet_id');
                    });
                });
            })

            // SearchBar x
            ->when(count($this->searchFilterInput) > 0, function (Builder $query) {
                $query->where(function (Builder $query) {

                    // Pour chaque mot clef
                    foreach ($this->searchFilterInput as $input) {

                        // Si le mot clef est un user
                        $query->when($input[0] == '1', function (Builder $query) use ($input) {
                            $query->orWhere('users.id', substr($input, 1));
                        });

                        // Si le mot clef est un item
                        $query->when($input[0] == '0', function (Builder $query) use ($input) {
                            foreach ($this->itemCategory as $category) {
                                $query->orWhere($category.'_id', substr($input, 1));
                            }
                        });
                    }
                });
            })

            ->where('unity_skins.status', 'Posted')

            // Concours anniversaire
            /*->when($this->orderByID === 5, function (Builder $query) {
                $subQuery = \DB::table('unity_skins as us2')
                    ->selectRaw('MAX(us2.id)') // ou MAX(created_at) + id
                    ->whereDate('us2.created_at', '2025-07-01')
                    ->whereColumn('us2.name', 'unity_skins.name')
                    ->groupBy('us2.name');

                $query->whereDate('unity_skins.created_at', '2025-07-01')
                    ->where('unity_skins.name', 'LIKE', '%#%')
                    ->whereIn('unity_skins.id', $subQuery);
            })*/

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

        $this->skinCount = count($this->postIdChunks);

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
    public function ToggleSkinContent(string $subcategoryID)
    {
        if (! in_array($subcategoryID, ItemSubcategorieEnum::values())) {
            return;
        }

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

    public function ToggleSearchedText(string $search): void
    {
        // Si le mot clef est déjà dans le tableau, on le retire
        if (count($this->searchFilterInput) > 0 && ($key = array_search($search, $this->searchFilterInput)) !== false) {
            unset($this->searchFilterInput[$key]);

            return;
        }

        $this->searchFilterInput[] = $search;
    }
}
