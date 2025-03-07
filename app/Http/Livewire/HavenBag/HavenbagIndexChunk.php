<?php

namespace App\Http\Livewire\HavenBag;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;
use stdClass;

class HavenbagIndexChunk extends Component
{
    /**
     * @var int[]
     */
    public $havenBagIds;

    /**
     * @var Collection<int|string, stdClass|null>
     */
    public $orderedHavenBags;

    public int $page;

    public int $itemsPerPage;

    /**
     * @return View
     */
    public function render()
    {
        $this->orderedHavenBags = $this->getHavenBags();

        return view('livewire.haven-bag.havenbag-index-chunk');
    }

    /**
     * @return Collection<(int|string), stdClass|null>
     */
    protected function getHavenBags()
    {
        $havenBags = DB::table('haven_bags')
            ->select('haven_bags.id', 'haven_bags.image_path', 'haven_bags.haven_bag_theme_id', 'haven_bags.user_id', 'haven_bags.name')
            ->join('haven_bag_themes', 'haven_bags.haven_bag_theme_id', '=', 'haven_bag_themes.id')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('users.id', 'haven_bags.user_id')
                    ->take(1),
            ])
            ->addSelect([
                'haven_bag_theme_name' => DB::table('localized_haven_bag_themes')
                    ->select('name')
                    ->where('locale', app()->getLocale())
                    ->whereColumn('localized_haven_bag_themes.dofus_id', 'haven_bag_themes.dofus_id')
                    ->take(1),
            ])
            ->addSelect([
                'popocket_icon_path' => DB::table('haven_bag_themes')
                    ->select('popocket_icon_path')
                    ->whereColumn('haven_bag_themes.id', 'haven_bags.haven_bag_theme_id')
                    ->take(1),
            ])
            ->whereIn('haven_bags.id', $this->havenBagIds)
            ->get();

        return collect($this->havenBagIds)->map(function ($id) use ($havenBags) {
            return $havenBags->where('id', $id)->first();
        });
    }
}
