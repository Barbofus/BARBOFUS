<?php

declare(strict_types=1);

namespace App\Actions\DofusDBApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Actions\DofusDBApi\SaveItemsFromDofusDB;

final class UpdateItemsFromDofusDBApi
{
    // Actions qui va pour chaque types d'item, lancer une autre action qui va get et save les items qu'il nous manque
    public function __invoke(): void{

        // Lance un changement, on lui donne dans l'ordre, le model lié (hat, cloak...), les typesID normaux et typesID d'apparât
        $newHats = (new SaveItemsFromDofusDB)('App\Models\DofusItemHat', [16], [246], 'images/icons/items/hats/');
        //$newPets = (new SaveItemsFromDofusDB)('App\Models\DofusItemPet', [18,121,97,196,207], [190,255,256,249,250], 'images/icons/items/pets/');


        //$newItems = array_merge($newHats, $newPets);

        dd($newHats);
    }
}
