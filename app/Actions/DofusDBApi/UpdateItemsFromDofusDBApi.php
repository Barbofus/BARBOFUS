<?php

declare(strict_types=1);

namespace App\Actions\DofusDBApi;

use App\Actions\Api\UpdateApiVersion;
use Illuminate\Support\Facades\Http;

final class UpdateItemsFromDofusDBApi
{
    /**
     * @return string[]
     */
    // Action qui va pour chaque types d'item, lancer une autre action qui va get et save les items qu'il nous manque
    public function __invoke(): array
    {
        $newItems = [];

        // Lance un changement, on lui donne dans l'ordre, le model lié (hat, cloak...), les typesID normaux et typesID d'apparât
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)('App\Models\DofusItemHat', [16], [246], 'images/icons/items/hats/'));
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)('App\Models\DofusItemCloak', [17], [247], 'images/icons/items/cloaks/'));
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)('App\Models\DofusItemShield', [82], [248], 'images/icons/items/shields/'));
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)('App\Models\DofusItemCostume', [], [199], 'images/icons/items/costumes/'));
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)('App\Models\DofusItemPet', [18, 121], [190, 255, 256, 249, 250], 'images/icons/items/pets/'));
        $newItems = array_merge($newItems, (new SaveHavenBagsFromDofusDB)('images/icons/heaven_bags'));

        // Cette ligne fetch les DD, Muldo et Volkorne, ils ne changeront pas, donc pas besoin de la relancer
        //$newPets = (new SaveItemsFromDofusDB)('App\Models\DofusItemPet', [97, 196, 207], [], 'images/icons/items/pets/');

        // Sauvegarde la nouvelle version dans notre fichier
        $newVersion = Http::get('https://api.dofusdb.fr/version')->body();

        (new UpdateApiVersion)('dofusDB', $newVersion);

        return $newItems;
    }
}
