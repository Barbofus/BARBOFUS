<?php

namespace App\Http\Livewire\UserPanel;

use App\Models\HavenBag;
use App\Notifications\HavenBagPostedNotification;
use App\Notifications\HavenBagRefusedNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class HavenBagsValidation extends Component
{
    /**
     * @var Collection<int, array<string, int|string>>
     */
    public $havenBags;

    public function render(): View
    {
        $this->getHavenBags();

        return view('livewire.user-panel.haven-bags-validation');
    }

    public function getHavenBags(): void
    {
        $this->havenBags = DB::table('haven_bags')->select('*')
            ->where('status', '=', 'pending')
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
                'haven_bag_theme_image_path' => DB::table('haven_bag_themes')
                    ->select('image_path')
                    ->whereColumn('id', 'haven_bags.haven_bag_theme_id')
                    ->take(1),
            ])
            ->addSelect([
                'popocket_icon_path' => DB::table('haven_bag_themes')
                    ->select('popocket_icon_path')
                    ->whereColumn('id', 'haven_bags.haven_bag_theme_id')
                    ->take(1),
            ])
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    public function acceptHavenBag(int $havenBagID): void
    {
        $havenBag = HavenBag::find($havenBagID);

        $havenBag->update([
            'status' => 'Posted',
        ]);

        $havenBag->User->notify(new HavenBagPostedNotification($havenBag));
        $this->dispatchBrowserEvent('alert-event', ['message' => 'Havre-sac ID#'.$havenBagID.' a été accepté']);
    }

    public function refuseHavenBag(string $reason, int $havenBagID): void
    {
        $havenBag = HavenBag::find($havenBagID);

        $havenBag->update([
            'status' => 'Refused',
            'refused_reason' => $reason,
        ]);

        $havenBag->User->notify(new HavenBagRefusedNotification($havenBag));
        $this->dispatchBrowserEvent('alert-event', ['message' => 'Havre-sac ID#'.$havenBagID.' a été refusé']);
    }
}
