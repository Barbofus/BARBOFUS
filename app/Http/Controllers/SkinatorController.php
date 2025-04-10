<?php

namespace App\Http\Controllers;

use App\Enums\ItemCategorieEnum;
use App\Models\Item;
use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SkinatorController extends Controller
{
    public function index()
    {
        // 2496 Coatox ; 8741 Yoroi ; 465 Gannon ; 9322 Kira
        if(!Gate::check('mod-access') &! Gate::check('admin-access') &! in_array(auth()->id(), [2496, 8741, 465, 9322]))  {
            abort(403);
        }

        return view('skins.skinator', [
            'breeds' => $this->getBreeds(),
            'itemCategories' => ItemCategorieEnum::values(),
            'items' => $this->getItems(),
        ]);
    }

    private function getItems()
    {
        return DB::table('items')
            ->select('dofus_id', 'icon_path', 'asset_id', 'female_asset_id', 'folder', 'category', 'subcategory', 'level', 'pet_type')
            ->addSelect([
                'name' => DB::table('localized_items')
                    ->select('name')
                    ->where('locale', app()->getLocale())
                    ->whereColumn('items.dofus_id', 'localized_items.dofus_id')
                    ->take(1),
            ])
            ->orderByRaw("FIELD(category, 'hat', 'cape', 'shield', 'pet', 'wings', 'shoulderpads', 'costume')")
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
            ->orderBy('name')
            ->get();

    }

    private function getBreeds()
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
