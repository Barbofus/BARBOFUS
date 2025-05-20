<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\Discord\SendDiscordPostedWebhook;
use App\Models\Skin;
use App\Models\UnitySkin;
use App\Notifications\SkinPostedNotification;
use App\Notifications\SkinRefusedNotification;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class SkinsValidation extends Component
{
    /**
     * @var string[]
     */
    protected $itemCategories = [
        'hat',
        'cape',
        'shield',
        'pet',
        'costume',
        'wings',
        'shoulderpads',
    ];

    public mixed $skins;

    public mixed $unitySkins;

    /**
     * @return void
     */
    public function getSkins()
    {
        $this->skins = DB::table('skins')->select('*')
            ->where('status', '=', 'pending')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_name' => DB::table('races')
                    ->select('name')
                    ->whereColumn('id', 'skins.race_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_icon' => DB::table('races')
                    ->select('ghost_icon_path')
                    ->whereColumn('id', 'skins.race_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_dofus_id' => DB::table('races')
                    ->select('dofus_id')
                    ->whereColumn('id', 'skins.race_id')
                    ->take(1),
            ])

            ->when(true, function (Builder $query) {
                foreach ($this->itemCategories as $category) {
                    if ($category == 'wings' || $category == 'shoulderpads') {
                        continue;
                    }
                    $query->addSelect([
                        $category.'_name' => DB::table('localized_items')
                            ->select('name')
                            ->where('locale', app()->getLocale())
                            ->whereColumn('dofus_id', 'skins.'.$category.'_id')
                            ->take(1),
                    ])
                        ->addSelect([
                            $category.'_icon' => DB::table('items')
                                ->select('icon_path')
                                ->whereColumn('dofus_id', 'skins.'.$category.'_id')
                                ->take(1),
                        ]);
                }
            })

            ->orderBy('updated_at', 'DESC')
            ->get();

        $this->unitySkins = DB::table('unity_skins')->select('*')
            ->whereIn('status', ['pending', 'refused'])
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'unity_skins.user_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_name' => DB::table('races')
                    ->select('name')
                    ->whereColumn('id', 'unity_skins.race_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_icon' => DB::table('races')
                    ->select('ghost_icon_path')
                    ->whereColumn('id', 'unity_skins.race_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_dofus_id' => DB::table('races')
                    ->select('dofus_id')
                    ->whereColumn('id', 'unity_skins.race_id')
                    ->take(1),
            ])

            ->when(true, function (Builder $query) {
                foreach ($this->itemCategories as $category) {
                    $query->addSelect([
                        $category.'_name' => DB::table('localized_items')
                            ->select('name')
                            ->where('locale', app()->getLocale())
                            ->whereColumn('dofus_id', 'unity_skins.'.$category.'_id')
                            ->take(1),
                    ])
                        ->addSelect([
                            $category.'_icon' => DB::table('items')
                                ->select('icon_path')
                                ->whereColumn('dofus_id', 'unity_skins.'.$category.'_id')
                                ->take(1),
                        ]);
                }
            })

            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    /**
     * @return void
     */
    public function acceptSkin(int $skinID)
    {
        $skin = Skin::find($skinID);

        $skin->update([
            'status' => 'Posted',
        ]);

        $skin->User->notify(new SkinPostedNotification($skin));
        $this->dispatchBrowserEvent('alert-event', ['message' => 'Skin ID#'.$skinID.' a été accepté']);

        (new SendDiscordPostedWebhook)(config('app.posted_webhook_url'), $skin);
    }

    /**
     * @return void
     */
    public function acceptUnitySkin(int $skinID)
    {
        $skin = UnitySkin::find($skinID);

        $skin->update([
            'status' => 'Posted',
        ]);

        $skin->User->notify(new SkinPostedNotification($skin, true));
        $this->dispatchBrowserEvent('alert-event', ['message' => 'Skin ID#'.$skinID.' a été accepté']);

        (new SendDiscordPostedWebhook)(config('app.posted_webhook_url'), $skin, true);
    }

    /**
     * @return void
     */
    public function refuseSkin(string $reason, int $skinID)
    {
        $skin = Skin::find($skinID);

        $skin->update([
            'status' => 'Refused',
            'refused_reason' => $reason,
        ]);

        $skin->User->notify(new SkinRefusedNotification($skin));
        $this->dispatchBrowserEvent('alert-event', ['message' => 'Skin ID#'.$skinID.' a été refusé']);
    }

    /**
     * @return void
     */
    public function refuseUnitySkin(string $reason, int $skinID)
    {
        $skin = UnitySkin::find($skinID);

        $skin->update([
            'status' => 'Refused',
            'refused_reason' => $reason,
        ]);

        $skin->User->notify(new SkinRefusedNotification($skin, true));
        $this->dispatchBrowserEvent('alert-event', ['message' => 'Skin ID#'.$skinID.' a été refusé']);
    }

    /**
     * @return View
     */
    public function render()
    {
        $this->getSkins();

        return view('livewire.user-panel.skins-validation');
    }
}
