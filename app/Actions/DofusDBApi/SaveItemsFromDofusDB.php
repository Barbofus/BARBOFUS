<?php

declare(strict_types=1);

namespace App\Actions\DofusDBApi;

use Illuminate\Support\Facades\Http;
use App\Actions\Api\FetchExternalFile;
use Illuminate\Support\Facades\Storage;
use App\Actions\DofusDBApi\GetItemsFromDofusDB;

final class SaveItemsFromDofusDB
{
    // Actions qui va déterminer si on a déjà l'item ou non, puis l'enregistrer, get les items depuis une autre action
    public function __invoke(
        $model,
        $typeIDs,
        $cosmetTypeIDs,
        $imagePath,
    ): array{

        $newItems = [];

        // Merge les typeId en un seul array
        $typeIDToPass = array_merge($typeIDs, $cosmetTypeIDs);

        // Action qui récupère les items contenu dans les typesID entré
        $items = (new GetItemsFromDofusDB)($typeIDToPass);

        // Parcour tous les items récupéré
        foreach($items as $item) {

            // Si on l'a déjà, passe à la boucle suivante
            if($model::where('dofus_id', '=', $item['id'])->exists()) {
                continue;
            }

            // De base on dit que c'est un item à jet (mimibiotable)
            $subCategoryId = 1;

            // typeID 113 ce sont les objets vivant
            if($item['typeId'] == 113) {
                $subCategoryId = 3;
            }

            // Si le typeId == à l'un de ceux dans les cosmet, alors c'est objet d'apparât
            foreach($cosmetTypeIDs as $cosmetTypeID){
                if($item['typeId'] == $cosmetTypeID) {
                    $subCategoryId = 2;

                    break;
                }
            }


            // Créer l'item en bdd
            $newItem = $model::create([
                'name' => $item['name'],
                'dofus_id' => $item['id'],
                'level' => $item['level'],
                'icon_path' => $imagePath.$item['iconId'],
                'dofus_items_sub_categorie_id' => $subCategoryId,
            ]);

            // Prépare l'url pour choper l'image
            $imageUrl = 'https://api.dofusdb.fr/img/items/'.$item['iconId'].'.png';

            // Récupère l'image et la stock dans l'icon_path
            (new FetchExternalFile)($imageUrl, $newItem['icon_path'].'.png');

            $newItems[] = $newItem->name;

        };

        return $newItems;
    }
}
