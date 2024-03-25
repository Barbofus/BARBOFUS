<?php

namespace App\Http\Controllers;

use App\Actions\Discord\GetDiscordUserInfo;
use App\Actions\Discord\SendDiscordPendingWebhook;
use App\Actions\Discord\SendDiscordPostedWebhook;
use App\Actions\Images\ResizeImages;
use App\Actions\Skins\DeleteSkin;
use App\Http\Middleware\SkinsOwnerShip;
use App\Http\Requests\StoreUpdateSkinRequest;
use App\Models\Skin;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SkinController extends Controller
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

    public function __construct()
    {
        $this->middleware(SkinsOwnerShip::class)->only(['edit', 'update', 'destroy']);
    }

    /**
     * @return View
     */
    public function index()
    {
        return view('skins.index');
    }

    /**
     * @return View
     */
    public function show(Skin $skin)
    {
        if ($skin->status != 'Posted' && $skin->user_id != auth()->id()) {
            abort(404);
        }

        $toShow = DB::table('skins')
            ->select('face', 'image_path', 'gender', 'color_skin', 'color_hair', 'color_cloth_1', 'color_cloth_2', 'color_cloth_3', 'skins.id', 'skins.name')
            ->where('skins.id', $skin->id)
            ->when(true, function (Builder $query) {
                foreach ($this->itemRelations as $item) {
                    $query->leftJoin($item.'s', $item.'s.id', '=', 'skins.'.$item.'_id');
                }
            })

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
                        ])
                        ->addSelect([
                            $item.'_level' => DB::table($item.'s')
                                ->select('level')
                                ->whereColumn('id', 'skins.'.$item.'_id')
                                ->take(1),
                        ])
                        ->addSelect([
                            $item.'_subname' => DB::table('dofus_items_sub_categories')
                                ->select('name')
                                ->whereColumn('id', $item.'s.dofus_items_sub_categorie_id')
                                ->take(1),
                        ])
                        ->addSelect([
                            $item.'_subicon' => DB::table('dofus_items_sub_categories')
                                ->select('icon_path')
                                ->whereColumn('id', $item.'s.dofus_items_sub_categorie_id')
                                ->take(1),
                        ]);
                }
            })
            ->first();

        $discord = (new GetDiscordUserInfo)($skin->user_id);

        return view('skins.show', [
            'skin' => $toShow,
            'discord' => $discord,
        ]);
    }

    /**
     * @return View
     */
    public function create()
    {
        $races = DB::table('races')
            ->select('*')
            ->get()->toArray();

        foreach ($races as $race) {
            $race->ghost_icon_path = asset('storage\/'.$race->ghost_icon_path);
            $race->colored_icon_path = asset('storage\/'.$race->colored_icon_path);
        }

        return view('skins.create', [
            'races' => $races,
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreUpdateSkinRequest $request)
    {
        // Resize de l'image, on affichera que 200px max
        $imagePath = (new ResizeImages)($request->image_path, 'images/skins', [
            'width' => 300,
            'height' => 390]);

        $skin = Skin::create([
            'dofus_item_hat_id' => $request->dofus_item_hat_id,
            'dofus_item_cloak_id' => $request->dofus_item_cloak_id,
            'dofus_item_shield_id' => $request->dofus_item_shield_id,
            'dofus_item_pet_id' => $request->dofus_item_pet_id,
            'dofus_item_costume_id' => $request->dofus_item_costume_id,
            'face' => $request->face,
            'image_path' => $imagePath,
            'gender' => $request->gender,
            'color_skin' => $request->color_skin,
            'color_hair' => $request->color_hair,
            'color_cloth_1' => $request->color_cloth_1,
            'color_cloth_2' => $request->color_cloth_2,
            'color_cloth_3' => $request->color_cloth_3,
            'user_id' => $request->user()->id,
            'race_id' => $request->race_id,
            'status' => (Gate::check('validate-skin')) ? 'Posted' : 'Pending',
            'name' => $request->name,
        ]);

        session()->flash('alert-message', 'Ton skin a été créé. Il est en attente de validation par un Modérateur');

        if (! Gate::check('validate-skin')) {
            (new SendDiscordPendingWebhook)(config('app.pending_webhook_url'), $skin);
        } else {
            (new SendDiscordPostedWebhook)(config('app.posted_webhook_url'), $skin);
        }

        return redirect()->route('user-dashboard.index', 'section=my-skins');
    }

    /**
     * @return View
     */
    public function edit(Skin $skin)
    {
        $races = DB::table('races')
            ->select('*')
            ->get()->toArray();

        foreach ($races as $race) {
            $race->ghost_icon_path = asset('storage\/'.$race->ghost_icon_path);
            $race->colored_icon_path = asset('storage\/'.$race->colored_icon_path);
        }

        return view('skins.edit', [
            'races' => $races,
            'skin' => $skin,
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function update(StoreUpdateSkinRequest $request, Skin $skin)
    {
        $imagePath = $skin->image_path;

        // Si on change l'image, supprime l'ancienne et s'occupe de la nouvelle
        if ($request->image_path) {
            \Storage::delete($skin->image_path);

            // Resize de l'image, on affichera que 200px max
            $imagePath = (new ResizeImages)($request->image_path, 'images/skins', [
                'width' => 300,
                'height' => 390]);
        }

        $skin->dofus_item_hat_id = $request->dofus_item_hat_id;
        $skin->dofus_item_cloak_id = $request->dofus_item_cloak_id;
        $skin->dofus_item_shield_id = $request->dofus_item_shield_id;
        $skin->dofus_item_pet_id = $request->dofus_item_pet_id;
        $skin->dofus_item_costume_id = $request->dofus_item_costume_id;
        $skin->face = $request->face;
        $skin->image_path = $imagePath;
        $skin->gender = $request->gender;
        $skin->color_skin = $request->color_skin;
        $skin->color_hair = $request->color_hair;
        $skin->color_cloth_1 = $request->color_cloth_1;
        $skin->color_cloth_2 = $request->color_cloth_2;
        $skin->color_cloth_3 = $request->color_cloth_3;
        $skin->race_id = $request->race_id;
        $skin->status = (Gate::check('validate-skin')) ? 'Posted' : 'Pending';
        $skin->name = $request->name;

        $skin->save();

        session()->flash('alert-message', 'Ton skin a été modifié. Il est en attente de validation par un Modérateur');

        if (! Gate::check('validate-skin')) {
            (new SendDiscordPendingWebhook)(config('app.pending_webhook_url'), $skin);
        } else {
            (new SendDiscordPostedWebhook)(config('app.posted_webhook_url'), $skin);
        }

        return redirect()->route('user-dashboard.index', 'section=my-skins');
    }

    /**
     * @return RedirectResponse
     */
    public function delete(int $skinID)
    {
        $skin = Skin::find($skinID);
        $skinUserName = $skin->User->name;

        (new DeleteSkin)($skinID);

        session()->flash('alert-message', 'Le Skin '.(($skin->name) ? $skin->name : 'ID#'.$skinID).' posté par '.$skinUserName.' a bien été supprimé.');

        return redirect()->route('skins.index');
    }
}
