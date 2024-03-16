<?php

namespace App\Http\Livewire\HavenBag;

use App\Actions\Utils\DoColorsMatch;
use App\Models\HavenBag;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
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

    public $initHavenBag;

    protected bool $hasLoadMore = false;



    public function render()
    {
        if (! $this->hasLoadMore) {
            $this->PrepareChunks();
        }

        if(request()->has('show')) {
            $this->initHavenBag = DB::table('haven_bags')
                ->select('id', 'image_path', 'haven_bag_theme_id', 'user_id', 'name')
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
                ->get();
        }

        return view('livewire.haven-bag.infinite-havenbag-index');
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
        $this->postIdChunks = DB::table('haven_bags')
            ->where('status', 'Posted')
            ->orderBy('created_at', 'DESC')
            ->pluck('id')
            ->toArray();

        // On chunk et on envoie !
        $this->postIdChunks = array_chunk($this->postIdChunks, self::ITEMS_PER_PAGE);

        $this->page = 1;

        $this->maxPage = count($this->postIdChunks);
    }

    /**
     * @return bool
     */
    public function HasMorePage()
    {
        return $this->page < $this->maxPage;
    }
}
