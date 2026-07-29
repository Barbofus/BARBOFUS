<?php

namespace App\Http\Livewire\UnitySkin;

use App\Actions\Utils\ComputeColorHsl;
use App\Enums\ItemSubcategorieEnum;
use App\Models\Race;
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
    public array $loadedPages = [];

    public int $randomSeed = 0;

    /**
     * @var int[]
     */
    public array $randomOrderIds = [];

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
        'detailed_views',
    ];

    /**
     * @var string[]
     */
    protected $itemCategory = [
        'hat',
        'cape',
        'shield',
        'weapon',
        'pet',
        'costume',
        'wings',
        'shoulderpads',
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

    public bool $currentMissSkinOnly = false;

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
        $this->randomSeed = mt_rand(1, 999999);

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
                            if (! in_array(intval($race_id), $breedIds)) {
                                continue;
                            }

                            $this->ToggleRace(intval($race_id));
                        }
                        break;
                    case 'search':
                        foreach (explode(',', $param) as $searchedName) {
                            $searchedName = trim($searchedName);
                            // Valider le format attendu : '0' (item) ou '1' (user) suivi uniquement de chiffres
                            if (preg_match('/^[01]\d{1,20}$/', $searchedName)) {
                                $this->ToggleSearchedText($searchedName);
                            }
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
     * Build the base filter query with JOINs + WHERE clauses only (no SELECT, no ORDER BY).
     */
    protected function buildFilterQuery(): Builder
    {
        $query = DB::table('unity_skins')
            ->join('users', 'unity_skins.user_id', '=', 'users.id')

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

            // Current Miss Skin only
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
            })*/;

        // Color filter in SQL
        if ($this->filterColor !== '') {
            $hsl = (new ComputeColorHsl)($this->filterColor);

            if ($hsl !== null) {
                $inputH = $hsl['hue'];
                $inputS = $hsl['saturation'];
                $inputL = $hsl['lightness'];

                $clothColumns = [
                    'color_cloth_1',
                    'color_cloth_2',
                    'color_cloth_3',
                    'color_cloth_4',
                ];

                $query->where(function (Builder $query) use ($clothColumns, $inputH, $inputS, $inputL) {
                    foreach ($clothColumns as $col) {
                        $query->orWhere(function (Builder $query) use ($col, $inputH, $inputS, $inputL) {
                            if ($inputS < 5) {
                                // Grayscale match
                                $query->where("{$col}_saturation", '<', 5)
                                    ->whereBetween("{$col}_lightness", [max(0, $inputL - 30), $inputL + 30]);
                            } else {
                                // Chromatic match
                                $query->whereBetween("{$col}_saturation", [max(0, $inputS - 29), $inputS + 29])
                                    ->whereBetween("{$col}_lightness", [max(0, $inputL - 29), $inputL + 29])
                                    ->where(function (Builder $query) use ($col, $inputH) {
                                        $query->orWhere(function (Builder $q) use ($col, $inputH) {
                                            $q->whereBetween("{$col}_hue", [0, 15])
                                                ->whereRaw('? BETWEEN 0 AND 15', [$inputH]);
                                        })
                                            ->orWhere(function (Builder $q) use ($col, $inputH) {
                                                $q->whereBetween("{$col}_hue", [12, 39])
                                                    ->whereRaw('? BETWEEN 12 AND 39', [$inputH]);
                                            })
                                            ->orWhere(function (Builder $q) use ($col, $inputH) {
                                                $q->whereBetween("{$col}_hue", [40, 65])
                                                    ->whereRaw('? BETWEEN 40 AND 65', [$inputH]);
                                            })
                                            ->orWhere(function (Builder $q) use ($col, $inputH) {
                                                $q->whereBetween("{$col}_hue", [65, 155])
                                                    ->whereRaw('? BETWEEN 65 AND 155', [$inputH]);
                                            })
                                            ->orWhere(function (Builder $q) use ($col, $inputH) {
                                                $q->whereBetween("{$col}_hue", [155, 250])
                                                    ->whereRaw('? BETWEEN 155 AND 250', [$inputH]);
                                            })
                                            ->orWhere(function (Builder $q) use ($col, $inputH) {
                                                $q->whereBetween("{$col}_hue", [250, 300])
                                                    ->whereRaw('? BETWEEN 250 AND 300', [$inputH]);
                                            })
                                            ->orWhere(function (Builder $q) use ($col, $inputH) {
                                                $q->whereBetween("{$col}_hue", [290, 345])
                                                    ->whereRaw('? BETWEEN 290 AND 345', [$inputH]);
                                            });
                                    });
                            }
                        });
                    }
                });
            }
        }

        return $query;
    }

    /**
     * Build the ordered query: adds SELECT + ORDER BY on top of buildFilterQuery().
     */
    protected function buildOrderedQuery(): Builder
    {
        $query = $this->buildFilterQuery();

        // Only addSelect for columns needed by ORDER BY
        if ($this->orderBy === 'rewards_points') {
            $query->addSelect([
                'rewards_points' => DB::table('unity_rewards')
                    ->selectRaw('sum(points)')
                    ->whereColumn('unity_rewards.unity_skin_id', 'unity_skins.id'),
            ]);
        }

        if ($this->orderBy === 'likes_count') {
            $query->addSelect([
                'likes_count' => DB::table('unity_likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('unity_likes.unity_skin_id', 'unity_skins.id'),
            ]);
        }

        // ORDER BY
        if ($this->randSort) {
            $query->orderByRaw('RAND(?)', [$this->randomSeed]);
        } else {
            $query->orderBy($this->orderBy, $this->orderDirection)
                ->when($this->orderByID == 4, function (Builder $query) {
                    $query->orderBy('unity_skins.created_at', 'ASC');
                })
                ->when($this->orderByID != 4, function (Builder $query) {
                    $query->orderBy('unity_skins.created_at', 'DESC');
                });
        }

        return $query;
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
            $offset = ($this->page - 1) * self::ITEMS_PER_PAGE;

            if ($this->randSort) {
                $this->loadedPages[$this->page - 1] = array_slice(
                    $this->randomOrderIds,
                    $offset,
                    self::ITEMS_PER_PAGE
                );
            } else {
                $orderedQuery = $this->buildOrderedQuery();
                $this->loadedPages[$this->page - 1] = (clone $orderedQuery)
                    ->limit(self::ITEMS_PER_PAGE)
                    ->offset($offset)
                    ->pluck('unity_skins.id')->toArray();
            }

            $this->hasLoadMore = true;
        }
    }

    /**
     * @return void
     */
    public function PrepareChunks()
    {
        // Random sort — fetch all IDs (lightweight, SELECT id only)
        if ($this->randSort) {
            $orderedQuery = $this->buildOrderedQuery();
            $this->randomOrderIds = (clone $orderedQuery)
                ->pluck('unity_skins.id')->toArray();
            $this->skinCount = count($this->randomOrderIds);
            $this->maxPage = (int) ceil($this->skinCount / self::ITEMS_PER_PAGE);
            $this->page = 1;
            $this->loadedPages = $this->skinCount > 0
                ? [array_slice($this->randomOrderIds, 0, self::ITEMS_PER_PAGE)]
                : [];
            $this->queryCount++;

            return; // early return for random case
        }

        // Deterministic sort
        $filterQuery = $this->buildFilterQuery();
        $this->skinCount = (clone $filterQuery)->count();
        $this->maxPage = (int) ceil($this->skinCount / self::ITEMS_PER_PAGE);
        $this->page = 1;
        $this->loadedPages = [];
        $this->randomOrderIds = [];

        if ($this->skinCount > 0) {
            $orderedQuery = $this->buildOrderedQuery();
            $this->loadedPages[0] = (clone $orderedQuery)
                ->limit(self::ITEMS_PER_PAGE)
                ->pluck('unity_skins.id')->toArray();
        }

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
        // Tri aléatoire désactivé temporairement (charge 50k+ IDs en mémoire)
        // if ($orderBy == count($this->allOrder)) {
        //     $this->randSort = true;
        //     $this->orderByID = $orderBy;
        //     $this->orderDirection = $orderDir;
        //     $this->randomSeed = mt_rand(1, 999999);
        //     return;
        // }

        // Protection contre les index invalides
        if ($orderBy < 0 || $orderBy >= count($this->allOrder)) {
            $orderBy = 0; // Retour au tri par défaut (nouveauté)
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
        // Valider le format pour éviter toute injection (0=item, 1=user, suivi d'un ID numérique)
        if (! preg_match('/^[01]\d{1,20}$/', $search)) {
            return;
        }

        // Si le mot clef est déjà dans le tableau, on le retire
        if (count($this->searchFilterInput) > 0 && ($key = array_search($search, $this->searchFilterInput)) !== false) {
            unset($this->searchFilterInput[$key]);

            return;
        }

        $this->searchFilterInput[] = $search;
    }
}
