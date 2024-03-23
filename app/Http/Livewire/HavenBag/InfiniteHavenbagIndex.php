<?php

namespace App\Http\Livewire\HavenBag;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class InfiniteHavenbagIndex extends Component
{
    public const ITEMS_PER_PAGE = 10;

    /**
     * @var array<int, int[]>
     */
    public $postIdChunks = [];

    public int $page = 1;

    public int $maxPage = 1;

    /**
     * @var null|Collection<string, array<int, Collection<string, mixed>>>
     */
    public $initHavenBag;

    /**
     * @var Collection<int, array<string, int|string>>
     */
    public $unselectedThemes;

    /**
     * @var Collection<int, array<string, int|string>>
     */
    public $selectedThemes;

    /**
     * @var int[]
     */
    public $selectedThemesID = [];

    protected bool $hasLoadMore = false;

    public function mount(): void
    {
    }

    /**
     * @return View
     */
    public function render()
    {
        $this->PrepareThemes();
        $this->CheckForRequest();

        if (! $this->hasLoadMore) {
            $this->PrepareChunks();
        }

        $this->dispatchBrowserEvent('haven-bag-change');

        return view('livewire.haven-bag.infinite-havenbag-index');
    }

    public function ToggleTheme(int $id): void
    {
        // Si le thème est déjà selectionné
        if (count($this->selectedThemesID) > 0 && ($key = array_search($id, $this->selectedThemesID)) !== false) {
            unset($this->selectedThemesID[$key]);

            return;
        }

        $this->selectedThemesID[] = $id;
    }

    protected function PrepareThemes(): void
    {
        $this->unselectedThemes = DB::table('haven_bag_themes')
            ->whereNotIn('id', $this->selectedThemesID)
            ->select('id', 'name', 'image_path')
            ->get();

        $this->selectedThemes = DB::table('haven_bag_themes')
            ->whereIn('id', $this->selectedThemesID)
            ->select('id', 'name', 'image_path')
            ->get();
    }

    protected function CheckForRequest(): void
    {
        $this->initHavenBag = null;

        if (request()->has('show')) {
            $this->initHavenBag = DB::table('haven_bags')
                ->select('id', 'image_path', 'haven_bag_theme_id', 'user_id', 'name', 'status')
                ->addSelect([
                    'user_name' => DB::table('users')
                        ->select('name')
                        ->whereColumn('id', 'haven_bags.user_id')
                        ->take(1),
                ])
                ->addSelect([
                    'haven_bag_theme_name' => DB::table('haven_bag_themes')
                        ->select('name')
                        ->whereColumn('id', 'haven_bags.haven_bag_theme_id')
                        ->take(1),
                ])
                ->addSelect([
                    'popocket_icon_path' => DB::table('haven_bag_themes')
                        ->select('popocket_icon_path')
                        ->whereColumn('id', 'haven_bags.haven_bag_theme_id')
                        ->take(1),
                ])
                ->where('id', request('show'))
                ->where('status', 'Posted')
                ->get();
        }
    }

    public function LoadMore(): void
    {
        if ($this->HasMorePage()) {
            $this->page++;
            $this->hasLoadMore = true;
        }
    }

    public function PrepareChunks(): void
    {
        $this->postIdChunks = DB::table('haven_bags')
            ->join('haven_bag_themes', 'haven_bags.haven_bag_theme_id', '=', 'haven_bag_themes.id')
            ->where('status', 'Posted')
            ->when(count($this->selectedThemesID) > 0, function (Builder $query) {
                $query->whereIn('haven_bag_themes.id', $this->selectedThemesID);
            })
            ->orderBy('haven_bags.created_at', 'DESC')
            ->pluck('haven_bags.id')
            ->toArray();

        // On chunk et on envoie !
        $this->postIdChunks = array_chunk($this->postIdChunks, self::ITEMS_PER_PAGE);

        $this->page = 1;

        $this->maxPage = count($this->postIdChunks);
    }

    public function HasMorePage(): bool
    {
        return $this->page < $this->maxPage;
    }
}
