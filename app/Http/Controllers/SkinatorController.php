<?php

namespace App\Http\Controllers;

use App\Enums\ItemCategorieEnum;
use App\Http\Middleware\UnitySkinsOwnerShip;
use App\Models\UnitySkin;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Actions\MissSkin\IsMissSkinTime;

class SkinatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(UnitySkinsOwnerShip::class)->only(['edit']);
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

        return view('skins.skinator', [
            'breeds' => $this->getBreeds(),
            'itemCategories' => ItemCategorieEnum::values(),
            'items' => $this->getItems(),
            'route' => route('unity-skins.store'),
            'skin' => $skin,
            'itemsCache' => json_decode(file_get_contents(storage_path('app/json/skinator/itemsCache.json'))),
            'method' => 'POST',
            'isMissSkinTime' => (new IsMissSkinTime)()
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
            'itemsCache' => json_decode(file_get_contents(storage_path('app/json/skinator/itemsCache.json'))),
            'method' => 'POST',
            'isMissSkinTime' => (new IsMissSkinTime)()
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
            'itemsCache' => json_decode(file_get_contents(storage_path('app/json/skinator/itemsCache.json'))),
            'method' => 'POST',
            'isMissSkinTime' => (new IsMissSkinTime)()
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
            'itemsCache' => json_decode(file_get_contents(storage_path('app/json/skinator/itemsCache.json'))),
            'method' => 'PUT',
            'isMissSkinTime' => (new IsMissSkinTime)()
        ]);
    }

    /**
     * @return Collection<int, \stdClass>
     */
    private function getItems(): Collection
    {
        $itemsData = json_decode(Storage::disk('local')->get('json/skinator/itemsExport.json'), true);

        $items = DB::table('items')
            ->select('dofus_id', 'icon_path', 'asset_id', 'female_asset_id', 'folder', 'category', 'subcategory', 'level', 'pet_type', 'colorable')
            ->addSelect([
                'name' => DB::table('localized_items')
                    ->select('name')
                    ->where('locale', app()->getLocale())
                    ->whereColumn('items.dofus_id', 'localized_items.dofus_id')
                    ->take(1),
            ])
            ->whereNotNull('asset_id')
            ->orderBy('updated_at', 'desc')
            /*->orderByRaw("FIELD(category, 'hat', 'cape', 'shield', 'pet', 'wings', 'shoulderpads', 'costume')")
            ->orderByRaw("FIELD(pet_type, 'familier', 'montilier', 'dragodinde', 'muldo', 'volkorne')")
            ->orderByRaw("
                CASE
                    WHEN pet_type IN ('dragodinde', 'muldo', 'volkorne') THEN
                        CASE
                            WHEN subcategory = 'ceremonial' THEN 0
                            WHEN subcategory = 'mimisymbic' THEN 1
                            ELSE 2
                        END
                    ELSE
                        CASE
                            WHEN subcategory = 'mimisymbic' THEN 0
                            WHEN subcategory = 'ceremonial' THEN 1
                            WHEN subcategory = 'livingObject' THEN 2
                            ELSE 3
                        END
                END
            ")
            ->orderBy('level')
            ->orderByRaw('name REGEXP ".* [0-9]+$" DESC')
            ->orderByRaw('TRIM(SUBSTRING_INDEX(name, " ", -1)) REGEXP "^[0-9]+$" DESC')
            ->orderByRaw('CASE
                    WHEN name REGEXP ".* [0-9]+$" THEN TRIM(SUBSTRING_INDEX(name, " ", LENGTH(name) - LENGTH(REPLACE(name, " ", ""))))
                    ELSE name
                END')
            ->orderByRaw('CASE
                    WHEN name REGEXP ".* [0-9]+$" THEN CAST(SUBSTRING_INDEX(name, " ", -1) AS UNSIGNED)
                    ELSE 0
                END')*/
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
            ->select('dofus_id', 'colors', 'heads')
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

                return $breed;
            });
    }
}
