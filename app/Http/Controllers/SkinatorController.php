<?php

namespace App\Http\Controllers;

use App\Actions\MissSkin\IsMissSkinTime;
use App\Enums\ItemCategorieEnum;
use App\Http\Middleware\UnitySkinsOwnerShip;
use App\Models\UnitySkin;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SkinatorController extends Controller
{
    public function __construct()
    {

        $this->middleware(UnitySkinsOwnerShip::class)->only(['edit']);
    }

    public function GetMissSkinTheme(): string
    {

        $missSkinData = json_decode(Storage::disk('local')->get('json/missskin.json'), true);

        return $missSkinData['theme'] ?? 'A définir';
    }

    public function create(Request $request): View
    {

        $skinId = $request->input('skin');

        $skin = null;

        if ($skinId) {

            $skin = UnitySkin::find($skinId);

            if (! $skin) {

                abort(404);
            }
        }

        $metaImage = null;

        $userAgent = $request->userAgent();

        // Discord bot or Twitter bot

        if (str_contains($userAgent, 'Discordbot') || str_contains($userAgent, 'Twitterbot')) {

            $s = $request->get('s');

            if ($s) {

                $metaImage = 'https://skinator.barbofus.com/renderer-server?s='.$s;
            }
        }

        return view('skins.skinator', [

            'breeds' => $this->getBreeds(),

            'itemCategories' => ItemCategorieEnum::values(),

            'items' => $this->getItems(),

            'route' => route('unity-skins.store'),

            'skin' => $skin,

            'itemsCache' => json_decode(file_get_contents(storage_path('app/json/skinator/itemsCache.json')) ?: '{}'),

            'method' => 'POST',

            'isMissSkinTime' => (new IsMissSkinTime)(),

            'missSkinTheme' => $this->GetMissSkinTheme(),

            'metaImage' => $metaImage,

        ]);
    }

    public function testator(Request $request): View
    {

        // 465 Gannon

        if (! Gate::check('mod-access') & ! Gate::check('admin-access') & auth()->id() != 465) {

            abort(403);
        }

        $skinId = $request->input('skin');

        $skin = null;

        if ($skinId) {

            $skin = UnitySkin::find($skinId);

            if (! $skin) {

                abort(404);
            }
        }

        return view('skins.testator', [

            'breeds' => $this->getBreeds(),

            'itemCategories' => ItemCategorieEnum::values(),

            'items' => $this->getItems(),

            'route' => route('unity-skins.store'),

            'skin' => $skin,

            'itemsCache' => json_decode(file_get_contents(storage_path('app/json/skinator/itemsCache.json')) ?: '{}'),

            'method' => 'POST',

            'isMissSkinTime' => (new IsMissSkinTime)(),

            'missSkinTheme' => $this->GetMissSkinTheme(),

        ]);
    }

    public function devator(Request $request): View
    {

        // 465 Gannon; 2496 Coatox; 3230 Mcdonald

        if (! Gate::check('mod-access') & ! Gate::check('admin-access') & ! in_array(auth()->id(), [465, 2496, 3230])) {

            abort(403);
        }

        $skinId = $request->input('skin');

        $skin = null;

        if ($skinId) {

            $skin = UnitySkin::find($skinId);

            if (! $skin) {

                abort(404);
            }
        }

        return view('skins.devator', [

            'breeds' => $this->getBreeds(),

            'itemCategories' => ItemCategorieEnum::values(),

            'items' => $this->getItems(),

            'route' => route('unity-skins.store'),

            'skin' => $skin,

            'itemsCache' => json_decode(file_get_contents(storage_path('app/json/skinator/itemsCache.json')) ?: '{}'),

            'method' => 'POST',

            'isMissSkinTime' => (new IsMissSkinTime)(),

            'missSkinTheme' => $this->GetMissSkinTheme(),

        ]);
    }

    public function edit(UnitySkin $skin): View
    {

        return view('skins.skinator', [

            'breeds' => $this->getBreeds(),

            'itemCategories' => ItemCategorieEnum::values(),

            'items' => $this->getItems(),

            'route' => route('unity-skins.update', $skin),

            'skin' => $skin,

            'itemsCache' => json_decode(file_get_contents(storage_path('app/json/skinator/itemsCache.json')) ?: '{}'),

            'method' => 'PUT',

            'isMissSkinTime' => (new IsMissSkinTime)(),

            'missSkinTheme' => $this->GetMissSkinTheme(),

        ]);
    }

    /**
     * @return Collection<int, \stdClass>
     */
    private function getItems(): Collection
    {

        $itemsData = json_decode(Storage::disk('local')->get('json/skinator/itemsExport.json') ?: '{}', true);

        $items = DB::table('items')

            ->select('dofus_id', 'icon_path', 'asset_id', 'female_asset_id', 'folder', 'category', 'subcategory', 'level', 'pet_type', 'weapon_type', 'colorable')

            ->addSelect([

                'name' => DB::table('localized_items')

                    ->select('name')

                    ->where('locale', app()->getLocale())

                    ->whereColumn('items.dofus_id', 'localized_items.dofus_id')

                    ->take(1),

            ])

            ->whereNotNull('asset_id')

            ->orderBy('updated_at', 'desc')

            ->get();

        $items->map(function ($item) use ($itemsData) {

            $item->kolors = $itemsData[$item->dofus_id]['kolors'] ?? null;

            $item->colorable = $itemsData[$item->dofus_id]['colorivant'] ?? null;
        });

        return $items;
    }

    /**
     * @return Collection<int, \stdClass>
     */
    private function getBreeds(): Collection
    {

        return DB::table('races')

            ->select('dofus_id', 'colors', 'heads', 'bodies')

            ->addSelect([

                'name' => DB::table('localized_races')

                    ->select('name')

                    ->where('locale', app()->getLocale())

                    ->whereColumn('races.dofus_id', 'localized_races.dofus_id')

                    ->take(1),

            ])

            ->get()

            ->map(function ($breed) {

                $breed->colors = json_decode($breed->colors);

                $breed->heads = json_decode($breed->heads);

                $breed->bodies = json_decode($breed->bodies);

                return $breed;
            });
    }
}
