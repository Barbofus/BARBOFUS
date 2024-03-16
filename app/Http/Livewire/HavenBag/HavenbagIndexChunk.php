<?php

namespace App\Http\Livewire\HavenBag;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HavenbagIndexChunk extends Component
{
    /**
     * @var int[]
     */
    public $havenBagIds;

    public $orderedHavenBags;

    public int $page;

    public int $itemsPerPage;

    public function render()
    {
        $this->orderedHavenBags = $this->getHavenBags();

        return view('livewire.haven-bag.havenbag-index-chunk');
    }

    protected function getHavenBags()
    {
        $havenBags = DB::table('haven_bags')
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
            ->whereIn('id', $this->havenBagIds)
            ->get();

        return collect($this->havenBagIds)->map(function ($id) use ($havenBags) {
            return $havenBags->where('id', $id)->first();
        });
    }
}
