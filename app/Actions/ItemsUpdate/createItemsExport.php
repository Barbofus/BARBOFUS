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
        $mountsData = json_decode(Storage::disk('local')->get('json/skinator/MountsRoot.json'), true)['references']['RefIds'];
        $itemsExport = json_decode(Storage::disk('local')->get('json/skinator/itemsExport.json'), true);

        $mountId = [];

        // Récupèration des bones de mount
        foreach ($mountsData as $mount) {
            if ($mount['type']['class'] != 'Mounts') {
                continue;
            }
            $md = $mount['data'];
            $look = $md['look'];

            // dd($look);

            if (preg_match('/^\{([^}]+)}/', $look, $matches)) {
                $parts = explode('|', $matches[1]);

                // dd($parts);
                $mountId[$md['id']]['boneId'] = $parts[0];

                // Le deuxième segment contient les couleurs, séparées par des virgules
                if (isset($parts[2]) && preg_match_all('/\d+=(\d+)/', $parts[2], $colorMatches)) {
                    $colors = $colorMatches[1]; // Contient uniquement les valeurs (ex: [16772045, 16772045, ...])

                    // S'assurer qu'on a bien 4 couleurs, sinon compléter avec null
                    // $colors = array_pad($colors, 4, null);

                    // Exemple de stockage dans un tableau structuré
                    $mountId[$md['id']]['colors'] = $colors;
                }
            }
        }

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

        /*$items = Item::whereNot(function ($query) {
            $query->whereIn('pet_type', ['dragodinde', 'muldo', 'volkorne'])
                ->where('subcategory', 'mimisymbic');
        })->orWhere('pet_type', null)->get();*/

        $items = Item::all();

        // $itemsExport = [];

        foreach ($items as $item) {
            $sprite = [
                0 => $item->asset_id,
                1 => $item->female_asset_id,
            ];

            if (in_array($item->pet_type, ['dragodinde', 'muldo', 'volkorne']) && $item->subcategory == 'mimisymbic') {
                $sprite = [
                    0 => (int) $mountId[$item->asset_id]['boneId'],
                    1 => (int) $mountId[$item->female_asset_id]['boneId'],
                ];
            }

            $entry = [
                'id' => $item->dofus_id,
                'category' => $item->category,
                'subcategory' => $item->subcategory,
                'pet_type' => $item->pet_type,
                'harn' => in_array($item->pet_type, ['dragodinde', 'muldo', 'volkorne']) && $item->subcategory != 'mimisymbic',
                'folder' => $item->folder,
                'sprite' => $sprite,
                'scale' => (in_array($item->pet_type, ['familier', 'montilier'])) ? ($jsonData[$item->dofus_id]['scales'] ?? [100]) : [100],
            ];

            if (! empty($jsonData[$item->dofus_id]['indexedColors']) && $itemsById[$item->dofus_id]['isColorable'] === 0) {
                $entry['indexedColors'] = array_map('intval', $jsonData[$item->dofus_id]['indexedColors']);
            }

            if (in_array($item->pet_type, ['dragodinde', 'muldo', 'volkorne']) && $item->subcategory == 'mimisymbic' && isset($mountId[$item->asset_id]['colors'])) {
                $entry['indexedColors'] = array_map('intval', $mountId[$item->asset_id]['colors']);
            }

            if (isset($itemsExport[$item->dofus_id]['colorivant'])) {
                $entry['colorivant'] = $itemsExport[$item->dofus_id]['colorivant'];
            }

            if (isset($itemsExport[$item->dofus_id]['kolors'])) {
                $entry['kolors'] = $itemsExport[$item->dofus_id]['kolors'];
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
