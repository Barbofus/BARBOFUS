<?php

namespace App\Http\Controllers;

use App\Models\UnitySkin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApiSkinController extends Controller
{
    /**
     * Get skin details with optimized queries
     */
    public function show(int $id): JsonResponse
    {
        // Récupérer le skin avec ses relations
        $skin = UnitySkin::with(['User', 'Race'])->find($id);

        if (! $skin) {
            return response()->json(['error' => 'Skin not found'], 404);
        }

        // Récupérer tous les items en une seule requête optimisée
        $itemIds = array_filter([
            $skin->hat_id,
            $skin->cape_id,
            $skin->shield_id,
            $skin->pet_id,
            $skin->costume_id,
            $skin->wings_id,
            $skin->shoulderpads_id,
            $skin->mount_id,
        ]);

        $items = [];
        if (! empty($itemIds)) {
            // Requête optimisée avec JOIN pour récupérer items + noms localisés
            $itemsData = DB::table('items')
                ->leftJoin('localized_items', function ($join) {
                    $join->on('items.dofus_id', '=', 'localized_items.dofus_id')
                        ->where('localized_items.locale', '=', 'fr');
                })
                ->select(
                    'items.id',
                    'items.dofus_id',
                    'items.level',
                    'items.category',
                    'items.subcategory',
                    'items.icon_path',
                    'items.colorable',
                    'localized_items.name'
                )
                ->whereIn('items.dofus_id', $itemIds)
                ->get()
                ->keyBy('dofus_id');

            // Indexer par dofus_id pour un accès rapide
            foreach ($itemsData as $item) {
                $items[$item->dofus_id] = [
                    'id' => $item->id,
                    'dofus_id' => $item->dofus_id,
                    'name' => $item->name ?? 'No name found',
                    'level' => $item->level,
                    'category' => $item->category,
                    'subcategory' => $item->subcategory,
                    'icon_path' => $item->icon_path,
                    'colorable' => $item->colorable,
                ];
            }
        }

        // Fonction helper pour récupérer un item formaté
        $getItem = function ($itemId) use ($items) {
            return $itemId && isset($items[$itemId]) ? $items[$itemId] : null;
        };

        return response()->json([
            'id' => $skin->id,
            'name' => $skin->name,
            'image_path' => $skin->image_path,
            'face' => $skin->face,
            'gender' => $skin->gender,
            'colors' => [
                'skin' => $skin->color_skin,
                'hair' => $skin->color_hair,
                'cloth_1' => $skin->color_cloth_1,
                'cloth_2' => $skin->color_cloth_2,
                'cloth_3' => $skin->color_cloth_3,
                'cloth_4' => $skin->color_cloth_4,
            ],
            'items' => [
                'hat' => $getItem($skin->hat_id),
                'cape' => $getItem($skin->cape_id),
                'shield' => $getItem($skin->shield_id),
                'pet' => $getItem($skin->pet_id),
                'costume' => $getItem($skin->costume_id),
                'wings' => $getItem($skin->wings_id),
                'shoulderPads' => $getItem($skin->shoulderpads_id),
                'mount' => $getItem($skin->mount_id),
            ],
            'user' => [
                'id' => $skin->User->id,
                'name' => $skin->User->name,
            ],
            'breed' => $skin->Race ? [
                'id' => $skin->Race->id,
                'name' => $skin->Race->name,
                'default_colors' => $skin->Race->colors,
                'heads' => $skin->Race->heads,
                'dofus_id' => $skin->Race->dofus_id,
            ] : null,
            'created_at' => $skin->created_at,
            'updated_at' => $skin->updated_at,
        ]);
    }
}
