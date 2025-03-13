<?php

namespace App\Http\Controllers;

use App\Models\Item;
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
            'items' => $this->getAllSkins(request()->has('test') ? request()->test : 'hat'),
        ]);
    }

    private function getAllSkins(string $category)
    {
        return DB::table('items')
            ->select('asset_id', 'folder', 'female_asset_id', 'icon_path', 'dofus_id', 'category')
            ->where('category', $category)
            ->addSelect([
                'name' => DB::table('localized_items')
                ->select('name')
                ->where('locale', app()->getLocale())
                ->whereColumn('dofus_id', 'items.dofus_id')
                ->take(1)
            ])
            ->get()->toArray();
    }
}
