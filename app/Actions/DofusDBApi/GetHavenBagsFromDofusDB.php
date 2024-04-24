<?php

declare(strict_types=1);

namespace App\Actions\DofusDBApi;

use App\Actions\Api\GetApiBody;

final class GetHavenBagsFromDofusDB
{
    /**
     * @return array<int<0, max>, array<string, mixed>>
     */
    // Actions qui va déterminer si on a déjà l'item ou non, puis l'enregistrer, get les items depuis une autre action
    public function __invoke(
    ): array {

        $limit = 50;
        $items = [];

        // Construit l'url
        $url = 'https://api.dofusdb.fr/havenbag-themes?$limit=0';

        // Récupère tous les items des typeID et cosmetTypeID
        $totalItems = (new GetApiBody)($url)->total;

        // On récupère les items de 50 en 50 (l'api a ses limites)
        for ($i = 0; $i < $totalItems / $limit; $i++) {

            // Construit l'url
            $url = 'https://api.dofusdb.fr/havenbag-themes?$limit='.$limit.'&$skip='.($i * $limit);

            // Récupère tous les items des typeID et cosmetTypeID
            $result = (new GetApiBody)($url)->data;

            // On remplit un tableau à nous, plus facilement éditable
            foreach ($result as $value) {
                $popocket_url = 'https://api.dofusdb.fr/items?typeId=203&typeId=218&possibleEffects.value='.$value->id.'&$limit=1';

                // Récupère tous les items des typeID et cosmetTypeID
                $popocket_result = (new GetApiBody)($popocket_url)->data;

                if (count($popocket_result) == 0) {

                    $items[] = [
                        'id' => $value->id,
                        'name' => $value->name->fr,
                        'mapId' => $value->mapId,
                        'image_path' => 'https://api.dofusdb.fr/img/maps/1/'.$value->mapId.'.jpg',
                        'has_popocket' => false,
                        'popocket_iconId' => 0,
                        'popocket_icon_path' => '',
                    ];

                    continue;
                }

                $items[] = [
                    'id' => $value->id,
                    'name' => $value->name->fr,
                    'mapId' => $value->mapId,
                    'image_path' => 'https://api.dofusdb.fr/img/maps/1/'.$value->mapId.'.jpg',
                    'has_popocket' => true,
                    'popocket_iconId' => $popocket_result[0]->iconId,
                    'popocket_icon_path' => 'https://api.dofusdb.fr/img/items/250/'.$popocket_result[0]->iconId.'.png',
                ];
            }
        }

        return $items;
    }
}
