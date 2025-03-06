<?php

declare(strict_types=1);

namespace App\Actions\DofusDBApi;

use App\Actions\Api\FetchExternalFile;
use App\Enums\ItemSubcategorieEnum;
use App\Enums\LocaleEnum;
use App\Models\Item;
use App\Models\LocalizedItem;

final class SaveItemsFromDofusDB
{
    /**
     * @param  int[]  $typeIDs
     * @param  int[]  $cosmetTypeIDs
     * @return array<int<0, max>, mixed>
     */
    // Action qui va déterminer si on a déjà l'item ou non, puis l'enregistrer, get les items depuis une autre action
    public function __invoke(
        array $typeIDs,
        array $cosmetTypeIDs,
        string $category,
    ): array {

        $newItems = [];
        $imagePath = 'images/icons/items/';

        // Merge les typeId en un seul array
        $typeIDToPass = array_merge($typeIDs, $cosmetTypeIDs);

        // Action qui récupère les items contenus dans les typesID entré
        $items = (new GetItemsFromDofusDB)($typeIDToPass);

        // Parcour tous les items récupérés
        foreach ($items as $item) {

            // Si on l'a déjà, passe à la boucle suivante
            if (Item::where('dofus_id', '=', $item['id'])->exists()) {
                continue;
            }

            // De base on dit que c'est un item à jet (mimibiotable)
            $subCategory = ItemSubcategorieEnum::MIMISYMBIC;

            // typeID 113 ce sont les objets vivant
            if ($item['typeId'] == 113) {
                $subCategory = ItemSubcategorieEnum::LIVINGOBJECT;
            }

            // Si le typeId == à l'un de ceux dans les cosmet, alors c'est objet d'apparât
            foreach ($cosmetTypeIDs as $cosmetTypeID) {
                if ($item['typeId'] == $cosmetTypeID) {
                    $subCategory = ItemSubcategorieEnum::CEREMONIAL;

                    break;
                }
            }

            // Construit le chemin pour l'image
            $iconPath = $imagePath.$item['iconId'];

            // Pour les DD, Muldo et Volkorne, on utilise une image unique
            switch ($item['typeId']) {
                case 97:
                    $iconPath = $imagePath.'dragodinde';
                    break;

                case 196:
                    $iconPath = $imagePath.'muldo';
                    break;

                case 207:
                    $iconPath = $imagePath.'volkorne';
                    break;
            }

            $petType = null;

            switch ($item['typeId']) {
                case 97:
                case 190:
                    $petType = 'dragodinde';
                    break;
                case 196:
                case 255:
                    $petType = 'muldo';
                    break;
                case 207:
                case 256:
                    $petType = 'volkorne';
                    break;
                case 18:
                case 249:
                    $petType = 'familier';
                    break;
                case 121:
                case 250:
                    $petType = 'montilier';
                    break;
            }

            $iconPath .= '.png';

            // Créer l'item en bdd
            $newItem = Item::create([
                'dofus_id' => $item['id'],
                'level' => $item['level'],
                'icon_path' => $iconPath,
                'category' => $category,
                'subcategory' => $subCategory,
                'pet_type' => $petType,
            ]);

            foreach ($item['name'] as $key => $locale) {
                if (in_array($key, LocaleEnum::values())) {
                    LocalizedItem::create([
                        'locale' => $key,
                        'dofus_id' => $item['id'],
                        'name' => $locale,
                    ]);
                }
            }

            // Pour les DD, Muldo et Volkorne, on ne récup pas l'image, ils ont tous la même
            if ($item['typeId'] != 97 && $item['typeId'] != 196 && $item['typeId'] != 207) {

                // Prépare l'url pour choper l'image
                $imageUrl = 'https://api.dofusdb.fr/img/items/'.$item['iconId'].'.png';

                // Récupère l'image et la stocke dans l'icon_path
                $imageFetched = (new FetchExternalFile)($imageUrl, $newItem['icon_path']);
                if (! $imageFetched) {
                    $newItem->update([
                        'icon_path' => 'images/misc_ui/question_mark.png',
                    ]);
                }
            }

            $newItems[] = [
                $newItem->name,
                $newItem->icon_path,
                $newItem->subcategory,
                $newItem->level,
            ];
        }

        return $newItems;
    }
}
