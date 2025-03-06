<?php

declare(strict_types=1);

namespace App\Actions\Utils;

use App\Models\DofusItemCloak;
use App\Models\DofusItemCostume;
use App\Models\DofusItemHat;
use App\Models\DofusItemPet;
use App\Models\DofusItemShield;
use App\Models\LocalizedItem;
use App\Models\Skin;
use App\Models\UnitySkin;

final class PopulateNewSkinItems
{
    public function __invoke(): void
    {
        /*$skins = Skin::all();

        foreach ($skins as $skin) {
            $skin->update([
                'hat_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemHat::find($skin->dofus_item_hat_id)?->name)->first()?->dofus_id,
                'cape_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemCloak::find($skin->dofus_item_cloak_id)?->name)->first()?->dofus_id,
                'shield_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemShield::find($skin->dofus_item_shield_id)?->name)->first()?->dofus_id,
                'pet_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemPet::find($skin->dofus_item_pet_id)?->name)->first()?->dofus_id,
                'costume_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemCostume::find($skin->dofus_item_costume_id)?->name)->first()?->dofus_id,
            ]);
        }

        $uskins = UnitySkin::all();

        foreach ($uskins as $uskin) {
            $uskin->update([
                'hat_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemHat::find($uskin->dofus_item_hat_id)?->name)->first()?->dofus_id,
                'cape_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemCloak::find($uskin->dofus_item_cloak_id)?->name)->first()?->dofus_id,
                'shield_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemShield::find($uskin->dofus_item_shield_id)?->name)->first()?->dofus_id,
                'pet_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemPet::find($uskin->dofus_item_pet_id)?->name)->first()?->dofus_id,
                'costume_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemCostume::find($uskin->dofus_item_costume_id)?->name)->first()?->dofus_id,
                'wings_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemCostume::find($uskin->dofus_item_wing_id)?->name)->first()?->dofus_id,
                'shoulderpads_id' => LocalizedItem::query()->where('locale', 'fr')->where('name', DofusItemCostume::find($uskin->dofus_item_shoulder_id)?->name)->first()?->dofus_id,
            ]);
        }*/
    }
}
