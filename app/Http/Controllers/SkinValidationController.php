<?php

namespace App\Http\Controllers;

use App\Models\Skin;
use App\Notifications\SkinPostedNotification;
use App\Notifications\SkinRefusedNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkinValidationController extends Controller
{


    protected $itemRelations = [
        'dofus_item_hat',
        'dofus_item_cloak',
        'dofus_item_shield',
        'dofus_item_pet',
        'dofus_item_costume',
    ];

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $skins = Skin::where('status', '=', 'pending')
            ->when(true, function (Builder $query) {
                foreach ($this->itemRelations as $item) {
                    $query->leftJoin($item . 's', $item . 's.id', '=', 'skins.' . $item . '_id');
                }
            })

            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id')
                    ->take(1)
            ])
            ->addSelect([
                'race_name' => DB::table('races')
                    ->select('name')
                    ->whereColumn('id', 'skins.race_id')
                    ->take(1)
            ])
            ->addSelect([
                'race_icon' => DB::table('races')
                    ->select('ghost_icon_path')
                    ->whereColumn('id', 'skins.race_id')
                    ->take(1)
            ])

            ->when(true, function (Builder $query) {
                foreach ($this->itemRelations as $item) {
                    $query->addSelect([
                        $item.'_name' => DB::table($item.'s')
                            ->select('name')
                            ->whereColumn('id', 'skins.'.$item.'_id')
                            ->take(1)
                    ])
                    ->addSelect([
                        $item.'_level' => DB::table($item.'s')
                            ->select('level')
                            ->whereColumn('id', 'skins.'.$item.'_id')
                            ->take(1)
                    ])
                    ->addSelect([
                        $item.'_icon' => DB::table($item.'s')
                            ->select('icon_path')
                            ->whereColumn('id', 'skins.'.$item.'_id')
                            ->take(1)
                    ])
                    ->addSelect([
                        $item.'_subcategorie_icon' => DB::table('dofus_items_sub_categories')
                            ->select('icon_path')
                            ->whereColumn('id', $item.'s.dofus_items_sub_categorie_id')
                            ->take(1)
                    ])
                    ->addSelect([
                        $item.'_subcategorie_name' => DB::table('dofus_items_sub_categories')
                            ->select('name')
                            ->whereColumn('id', $item.'s.dofus_items_sub_categorie_id')
                            ->take(1)
                    ]);
                }
            })
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('admin_panel.skins-validation', [
            'skins' => $skins
        ]);
    }

    public function accept(Request $request, Skin $skin)
    {
        $skin->update([
           'status' => 'Posted'
        ]);

        $skin->User->notify(new SkinPostedNotification($skin));

        return back();
    }

    public function refuse(Request $request, Skin $skin)
    {
        $skin->update([
            'status' => 'Refused',
            'refused_reason' => $request->reason
        ]);

        $skin->User->notify(new SkinRefusedNotification($skin));

        return back();
    }
}
