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
        // 2496 Coatox ; 8741 Yoroi ; 465 Gannon
        if(!Gate::check('mod-access') &! Gate::check('admin-access') &! in_array(auth()->id(), [2496, 8741, 465]))  {
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
            ->select('dofus_id', 'icon_path', 'asset_id', 'female_asset_id', 'folder', 'category', 'subcategory', 'level')
            ->addSelect([
                'name' => DB::table('localized_items')
                    ->select('name')
                    ->where('locale', app()->getLocale())
                    ->whereColumn('items.dofus_id', 'localized_items.dofus_id')
                    ->take(1),
            ])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('items as i')
                    ->whereColumn('i.dofus_id', 'items.dofus_id')
                    ->where('i.subcategory', 'mimisymbic')
                    ->whereIn('i.pet_type', ['dragodinde', 'volkorne', 'muldo']);
            })
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
