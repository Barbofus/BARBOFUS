<?php

namespace App\Http\Livewire\UserPanel;

use App\Models\Skin;
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
    protected $itemRelations = [
        'dofus_item_hat',
        'dofus_item_cloak',
        'dofus_item_shield',
        'dofus_item_pet',
        'dofus_item_costume',
    ];

    public mixed $skins;

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

            ->when(true, function (Builder $query) {
                foreach ($this->itemRelations as $item) {
                    $query->addSelect([
                        $item.'_name' => DB::table($item.'s')
                            ->select('name')
                            ->whereColumn('id', 'skins.'.$item.'_id')
                            ->take(1),
                    ])
                        ->addSelect([
                            $item.'_icon' => DB::table($item.'s')
                                ->select('icon_path')
                                ->whereColumn('id', 'skins.'.$item.'_id')
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
