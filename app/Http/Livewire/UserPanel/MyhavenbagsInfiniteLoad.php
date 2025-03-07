<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\HavenBag\DeleteHavenBag;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class MyhavenbagsInfiniteLoad extends Component
{
    /**
     * @var Collection<int, \stdClass>
     */
    public $havenBags;

    public function render(): View
    {
        $this->getHavenBags();

        return view('livewire.user-panel.myhavenbag-infinite-load');
    }

    protected function getHavenBags(): void
    {
        $this->havenBags = DB::table('haven_bags')
            ->select('haven_bags.id', 'haven_bags.image_path', 'haven_bags.haven_bag_theme_id', 'haven_bags.name', 'haven_bags.user_id', 'haven_bags.status', 'haven_bags.created_at')
            ->join('haven_bag_themes', 'haven_bags.haven_bag_theme_id', '=', 'haven_bag_themes.id')
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
            ->where('user_id', auth()->user()->id)
            ->orderBy('status', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($this->havenBags as $havenBag) {
            $havenBag->created_at = new Carbon($havenBag->created_at);
        }
    }

    public function deleteHavenBag(int $havenBagID): void
    {
        (new DeleteHavenBag)($havenBagID);

        $this->dispatchBrowserEvent('alert-event', ['message' => __('barbofus.alertDeleteHS', ['id' => $havenBagID])]);
    }
}
