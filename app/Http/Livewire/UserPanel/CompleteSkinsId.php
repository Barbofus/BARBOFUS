<?php

namespace App\Http\Livewire\UserPanel;

use App\Enums\ItemCategorieEnum;
use App\Models\Item;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;
use stdClass;

class CompleteSkinsId extends Component
{
    /** @var Collection<int, stdClass> */
    public Collection $remainingItems;

    /** @var Collection<int, stdClass> */
    public Collection $remainingCostume;

    public function render(): View
    {
        $this->getRemainingItems();
        $this->getRemainingCostume();

        return view('livewire.user-panel.complete-skins-id');
    }

    private function getRemainingItems(): void
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
                    ->whereColumn('dofus_id', 'items.dofus_id')
                    ->take(1),
            ])->get();
    }

    private function getRemainingCostume(): void
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
                    ->whereColumn('dofus_id', 'items.dofus_id')
                    ->take(1),
            ])->get();
    }

    public function useSkinId(int $skinId, int $itemId): void
    {
        Item::where('dofus_id', $itemId)->update(['asset_id' => $skinId]);
        Item::where('dofus_id', $itemId)->update(['female_asset_id' => $skinId]);
    }

    public function useSkinIdCostume(int $itemId, int $skinIdMale, int $skinIdFemale): void
    {
        Item::where('dofus_id', $itemId)->update(['asset_id' => $skinIdMale]);
        Item::where('dofus_id', $itemId)->update(['female_asset_id' => $skinIdFemale]);
    }
}
