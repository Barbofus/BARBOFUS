<?php

namespace App\Http\Livewire\UserPanel;

use App\Enums\ItemCategorieEnum;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CompleteSkinsId extends Component
{
    public $remainingItems = [];
    public $remainingCostume = [];


    public function render()
    {
        $this->getRemainingItems();
        $this->getRemainingCostume();
        return view('livewire.user-panel.complete-skins-id');
    }

    private function getRemainingItems()
    {
        $this->remainingItems = DB::table('items')
            ->select('dofus_id', 'icon_path')
            ->where(function ($query) {
                $query->whereNull('asset_id')
                    ->orWhereNull('female_asset_id');
            })
            ->where('category', '!=', ItemCategorieEnum::COSTUME)
            ->addSelect([
                'name' => DB::table('localized_items')
                    ->select('name')
                    ->where('locale', app()->getLocale())->take(1)
                    ->whereColumn( 'dofus_id', 'items.dofus_id')
                    ->take(1)
            ])->get();
    }

    private function getRemainingCostume()
    {
        $this->remainingCostume = DB::table('items')
            ->select('dofus_id', 'icon_path')
            ->where(function ($query) {
                $query->whereNull('asset_id')
                    ->orWhereNull('female_asset_id');
            })
            ->where('category', '=', ItemCategorieEnum::COSTUME)
            ->addSelect([
                'name' => DB::table('localized_items')
                    ->select('name')
                    ->where('locale', app()->getLocale())->take(1)
                    ->whereColumn( 'dofus_id', 'items.dofus_id')
                    ->take(1)
            ])->get();
    }

    public function useSkinId(int $skinId, int $itemId)
    {
            Item::where('dofus_id', $itemId)->update(['asset_id' => $skinId]);
            Item::where('dofus_id', $itemId)->update(['female_asset_id' => $skinId]);
    }

    public function useSkinIdCostume(int $itemId, int $skinIdMale, int $skinIdFemale)
    {
        Item::where('dofus_id', $itemId)->update(['asset_id' => $skinIdMale]);
        Item::where('dofus_id', $itemId)->update(['female_asset_id' => $skinIdFemale]);
    }
}
