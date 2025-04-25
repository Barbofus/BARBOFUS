<?php

declare(strict_types=1);

namespace App\Actions\ItemsUpdate;

use App\Models\Item;
use App\Models\Like;
use App\Models\UnityLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

final class createItemsExport
{
    /**
     * @return void
     */
    public function __invoke()
    {
        $jsonPath = storage_path('app/json/skinator/outBonesSize.json');
        $jsonData = json_decode(file_get_contents($jsonPath), true);

        $items = Item::whereNot(function ($query) {
            $query->whereIn('pet_type', ['dragodinde', 'muldo', 'volkorne'])
                ->where('subcategory', 'mimisymbic');
        })->orWhere('pet_type', null)->get();

        $itemsExport = [];

        foreach ($items as $item) {
            $itemsExport[$item->dofus_id] = [
                'id' => $item->dofus_id,
                'category' => $item->category,
                'subcategory' => $item->subcategory,
                'pet_type' => $item->pet_type,
                'harn' => in_array($item->pet_type, ['dragodinde', 'muldo', 'volkorne']),
                'folder' => $item->folder,
                'sprite' => [
                    0 => $item->asset_id,
                    1 => $item->female_asset_id,
                ],
                'scale' => (in_array($item->pet_type, ['familier', 'montilier'])) ? ($jsonData[$item->dofus_id]['scales']) ?: 100 : 100,
            ];
        }

        // Enregistrement du fichier
        Storage::disk('local')->put('json/skinator/itemsExport.json', json_encode($itemsExport, JSON_PRETTY_PRINT));
    }
}
