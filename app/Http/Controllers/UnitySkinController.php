<?php

namespace App\Http\Controllers;

use App\Actions\Discord\GetDiscordUserInfo;
use App\Actions\Discord\SendDiscordPendingWebhook;
use App\Actions\Discord\SendDiscordPostedWebhook;
use App\Actions\Images\ResizeImages;
use App\Actions\Skins\DeleteSkin;
use App\Http\Middleware\UnitySkinsOwnerShip;
use App\Http\Requests\StoreUpdateUnitySkinRequest;
use App\Models\UnitySkin;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UnitySkinController extends Controller
{
    /**
     * @var string[]
     */
    protected $itemCategories = [
        'hat',
        'cape',
        'shield',
        'pet',
        'mount',
        'costume',
        'wings',
        'shoulderpads',
    ];

    public function __construct()
    {
        $this->middleware(UnitySkinsOwnerShip::class)->only(['edit', 'update', 'destroy']);
    }

    /**
     * @return View
     */
    public function index()
    {
        return view('unity-skins.index');
    }

    /**
     * @return View
     */
    public function show(UnitySkin $skin)
    {
        if ($skin->status != 'Posted' && $skin->user_id != auth()->id()) {
            abort(404);
        }

        $headsData = json_decode(Storage::disk('local')->get('json/skinator/HeadsRoot.json'), true)['references']['RefIds'];

        $toShow = DB::table('unity_skins')
            ->select('face', 'image_path', 'user_id', 'gender', 'color_skin', 'color_hair', 'color_cloth_1', 'color_cloth_2', 'color_cloth_3', 'color_cloth_4', 'unity_skins.id', 'unity_skins.name')
            ->join('races', 'unity_skins.race_id', '=', 'races.dofus_id')
            ->where('unity_skins.id', $skin->id)
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'unity_skins.user_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_name' => DB::table('localized_races')
                    ->select('name')
                    ->where('locale', app()->getLocale())
                    ->whereColumn('races.dofus_id', 'localized_races.dofus_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_icon' => DB::table('races')
                    ->select('ghost_icon_path')
                    ->whereColumn('dofus_id', 'unity_skins.race_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_dofus_id' => DB::table('races')
                    ->select('dofus_id')
                    ->whereColumn('id', 'unity_skins.race_id')
                    ->take(1),
            ])
            ->addSelect([
                'is_liked' => DB::table('unity_likes')
                    ->select('id')
                    ->whereColumn('unity_skin_id', 'unity_skins.id')
                    ->where('user_id', Auth::id())
                    ->orWhereColumn('unity_skin_id', 'unity_skins.id')
                    ->where('ip_adress', request()->ip())
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
                        ])
                        ->addSelect([
                            $category.'_level' => DB::table('items')
                                ->select('level')
                                ->whereColumn('dofus_id', 'unity_skins.'.$category.'_id')
                                ->take(1),
                        ])
                        ->addSelect([
                            $category.'_subname' => DB::table('items')
                                ->select('subcategory')
                                ->whereColumn('dofus_id', 'unity_skins.'.$category.'_id')
                                ->take(1),
                        ]);
                }
            })
            ->first();

        /** @var object{face: int} $toShow */
        $head = array_filter($headsData, function ($item) use ($toShow) {
            return isset($item['data']['id']) && $item['data']['id'] === $toShow->face;
        });

        $headId = reset($head)['data']['assetId'];

        $discord = (new GetDiscordUserInfo)($skin->user_id);

        return view('unity-skins.show', [
            'skin' => $toShow,
            'discord' => $discord,
            'head' => $headId,
        ]);
    }

    /**
     * @return View
     */
    public function create()
    {
        $races = DB::table('races')
            ->select('*')
            ->addSelect([
                'localized_name' => DB::table('localized_races')
                    ->select('name')
                    ->where('locale', app()->getLocale())
                    ->whereColumn('races.dofus_id', 'localized_races.dofus_id')
                    ->take(1),
            ])
            ->get()->toArray();

        foreach ($races as $race) {
            $race->ghost_icon_path = asset('storage\/'.$race->ghost_icon_path);
            $race->colored_icon_path = asset('storage\/'.$race->colored_icon_path);
        }

        return view('unity-skins.create', [
            'races' => $races,
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreUpdateUnitySkinRequest $request)
    {
        // Resize de l'image, on affichera que 200px max
        $imagePath = (new ResizeImages)($request->image_path, 'images/skins', [
            'width' => 300,
            'height' => 500]); // 390

        $skin = UnitySkin::create([
            'hat_id' => $request->hat_id,
            'cape_id' => $request->cape_id,
            'shield_id' => $request->shield_id,
            'pet_id' => $request->pet_id,
            'mount_id' => $request->mount_id,
            'costume_id' => $request->costume_id,
            'wings_id' => $request->wings_id,
            'shoulderpads_id' => $request->shoulderpads_id,
            'face' => $request->face,
            'image_path' => $imagePath,
            'gender' => $request->gender,
            'color_skin' => ltrim($request->color_skin, '#'),
            'color_hair' => ltrim($request->color_hair, '#'),
            'color_cloth_1' => ltrim($request->color_cloth_1, '#'),
            'color_cloth_2' => ltrim($request->color_cloth_2, '#'),
            'color_cloth_3' => ltrim($request->color_cloth_3, '#'),
            'color_cloth_4' => ltrim($request->color_cloth_4, '#'),
            'user_id' => $request->user()->id,
            'race_id' => $request->race_id,
            'status' => (Gate::check('validate-skin')) ? 'Posted' : 'Pending',
            'name' => $request->name,
        ]);

        session()->flash('alert-message', __('barbofus.alertSkinCreated'));

        if (! Gate::check('validate-skin')) {
            (new SendDiscordPendingWebhook)(config('app.pending_webhook_url'), $skin);
        } else {
            (new SendDiscordPostedWebhook)(config('app.posted_webhook_url'), $skin, true);
        }

        return redirect()->route('user-dashboard.index', 'section=my-unity-skins');
    }

    /**
     * @return View
     */
    public function edit(UnitySkin $skin)
    {
        $races = DB::table('races')
            ->select('*')
            ->addSelect([
                'localized_name' => DB::table('localized_races')
                    ->select('name')
                    ->where('locale', app()->getLocale())
                    ->whereColumn('races.dofus_id', 'localized_races.dofus_id')
                    ->take(1),
            ])
            ->get()->toArray();

        foreach ($races as $race) {
            $race->ghost_icon_path = asset('storage\/'.$race->ghost_icon_path);
            $race->colored_icon_path = asset('storage\/'.$race->colored_icon_path);
        }

        return view('unity-skins.edit', [
            'races' => $races,
            'skin' => $skin,
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function update(StoreUpdateUnitySkinRequest $request, UnitySkin $skin)
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

        $skin->hat_id = $request->hat_id;
        $skin->cape_id = $request->cape_id;
        $skin->shield_id = $request->shield_id;
        $skin->pet_id = $request->pet_id;
        $skin->mount_id = $request->mount_id;
        $skin->costume_id = $request->costume_id;
        $skin->wings_id = $request->wings_id;
        $skin->shoulderpads_id = $request->shoulderpads_id;
        $skin->face = $request->face;
        $skin->image_path = $imagePath;
        $skin->gender = $request->gender;
        $skin->color_skin = ltrim($request->color_skin, '#');
        $skin->color_hair = ltrim($request->color_hair, '#');
        $skin->color_cloth_1 = ltrim($request->color_cloth_1, '#');
        $skin->color_cloth_2 = ltrim($request->color_cloth_2, '#');
        $skin->color_cloth_3 = ltrim($request->color_cloth_3, '#');
        $skin->color_cloth_4 = ltrim($request->color_cloth_4, '#');
        $skin->race_id = $request->race_id;
        $skin->status = (Gate::check('validate-skin')) ? 'Posted' : 'Pending';
        $skin->name = $request->name;

        $skin->save();

        session()->flash('alert-message', __('barbofus.alertSkinEdited'));

        if (! Gate::check('validate-skin')) {
            (new SendDiscordPendingWebhook)(config('app.pending_webhook_url'), $skin);
        } else {
            (new SendDiscordPostedWebhook)(config('app.posted_webhook_url'), $skin, true);
        }

        return redirect()->route('user-dashboard.index', 'section=my-unity-skins');
    }

    /**
     * @return RedirectResponse
     */
    public function delete(int $skinID)
    {
        $skin = UnitySkin::find($skinID);
        $skinUserName = $skin->User->name;

        (new DeleteSkin)($skinID, true);

        session()->flash('alert-message', __('barbofus.alertDeleteSkin', ['skin' => (($skin->name) ?: 'ID#'.$skinID), 'username' => $skinUserName]));

        return redirect()->route('unity-skins.index');
    }
}
