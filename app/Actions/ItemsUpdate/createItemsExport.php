<?php

declare(strict_types=1);

namespace App\Actions\ItemsUpdate;

use App\Models\Item;
use Illuminate\Support\Facades\Storage;

final class createItemsExport
{
    /**
     * @return void
     */
    public function __invoke()
    {
        $jsonData = json_decode(Storage::disk('local')->get('json/skinator/outBonesSize.json'), true);
        $itemsData = json_decode(Storage::disk('local')->get('json/skinator/ItemsRoot.json'), true)['references']['RefIds'];

        // Indexe les items par leur ID pour un accès rapide
        $itemsById = [];
        foreach ($itemsData as $item) {
            if ($item['type']['ns'] != 'Core.DataCenter.Metadata.Item') {
                continue;
            }
            if (! in_array($item['data']['id'], array_keys($jsonData))) {
                continue;
            }
            $itemsById[$item['data']['id']] = $item['data'];
        }

        $items = Item::whereNot(function ($query) {
            $query->whereIn('pet_type', ['dragodinde', 'muldo', 'volkorne'])
                ->where('subcategory', 'mimisymbic');
        })->orWhere('pet_type', null)->get();

        $itemsExport = [];

        foreach ($items as $item) {
            $entry = [
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
                'scale' => (in_array($item->pet_type, ['familier', 'montilier'])) ? ($jsonData[$item->dofus_id]['scales'] ?? [100]) : [100],
            ];

            if (! empty($jsonData[$item->dofus_id]['indexedColors']) && $itemsById[$item->dofus_id]['isColorable'] === 0) {
                $entry['indexedColors'] = $jsonData[$item->dofus_id]['indexedColors'];
            }

            $itemsExport[$item->dofus_id] = $entry;
        }

        $jsonItemsExport = json_encode($itemsExport, JSON_PRETTY_PRINT);

        if ($jsonItemsExport === false) {
            // Gérer l'erreur si json_encode échoue
            dd('ERREUR - Lors de l\'export de itemsExport.json');
        }

        Storage::disk('local')->put('json/skinator/itemsExport.json', $jsonItemsExport);
    }
}
