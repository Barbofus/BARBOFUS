<?php

declare(strict_types=1);

namespace App\Actions\DofusDBApi;

use App\Actions\Api\GetApiBody;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

final class GetItemsFromDofusDB
{
    // Actions qui va déterminer si on a déjà l'item ou non, puis l'enregistrer, get les items depuis une autre action
    public function __invoke(
        $typeID
    ): array{

        $limit = 50;
        $items = [];

        // Construit un string avec les &typesId= pour la requête
        $typeIDString = '';

        foreach($typeID as $value) {
            $typeIDString .= "&typeId=$value";
        }

        // Construit l'url
        $url = 'https://api.dofusdb.fr/items?'.$typeIDString.'&$limit=0';

        // Récupère tous les items des typeID et cosmetTypeID
        $totalItems = (new GetApiBody)($url)->total;

        // On récupère les items de 50 en 50 (l'api a ses limites)
        for($i = 0; $i < $totalItems/$limit; $i++) {

            // Construit l'url
            $url = 'https://api.dofusdb.fr/items?'.$typeIDString.'&$limit='.$limit.'&$skip='.($i*$limit).'&$select[]=id&$select[]=iconId&$select[]=name.fr&$select[]=level&$select[]=typeId';

            // Récupère tous les items des typeID et cosmetTypeID
            $result = (new GetApiBody)($url)->data;

            // On remplit un tableau à nous, plus facilement éditable
            foreach($result as $value) {
                $items[] = [
                    'id' => $value->id,
                    'name' => $value->name->fr,
                    'level' => $value->level,
                    'iconId' => $value->iconId,
                    'typeId' => $value->typeId,
                ];
            }
        }





        // Récupère tous les objets vivants qui sont compatible avec typeID
        if(in_array(16, $typeID) || in_array(17, $typeID)|| in_array(82, $typeID)) {

            // Construit un string avec les &typesID= pour la requête
            $typeIDString = '';

            foreach($typeID as $value) {
                $typeIDString .= "&possibleEffects.value=$value";
            }

            // Construit l'url
            $url = 'https://api.dofusdb.fr/items?typeId=113'.$typeIDString.'&$limit=0';

            // Récupère tous les items des typeID et cosmetTypeID
            $totalItems = (new GetApiBody)($url)->total;

            // On récupère les items de 50 en 50 (l'api a ses limites)
            for($i = 0; $i < $totalItems/$limit; $i++) {

                // Construit l'url pour les objets vivant
                $url = 'https://api.dofusdb.fr/items?typeId=113'.$typeIDString.'&$limit='.$limit.'&$skip='.($i*$limit).'&$select[]=id&$select[]=name.fr&$select[]=level';

                // Récupère tous les objets vivants du même typeId
                $livingObjects = (new GetApiBody)($url)->data;

                // Pour chaque objets vivant, on veux récupérer les différents niveaux (stocké ailleurs)
                foreach($livingObjects as $livingObject) {
                    $url = 'https://api.dofusdb.fr/living-object-skin-jnt-mood/'.$livingObject->id.'?lang=fr';


                    // Récupère tous les objets vivants du même typeId
                    $result = (new GetApiBody)($url);

                    // Pour chaque moods normal (donc key 1), on ajoute un item dans $items avec l'id du mood, son lien d'image, le $livingObject->level et le $livingObject->name + mood id
                    foreach($result->moods[1] as $key => $mood) {
                        $items[] = [
                            'id' => $mood,
                            'name' => $livingObject->name->fr.' '.($key + 1),
                            'level' => $livingObject->level,
                            'iconId' => $mood,
                            'typeId' => 113,
                        ];
                    }
                }
            }
        }

        return $items;
    }
}
