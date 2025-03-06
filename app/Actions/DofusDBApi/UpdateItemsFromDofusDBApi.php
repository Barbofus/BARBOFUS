<?php

declare(strict_types=1);

namespace App\Actions\DofusDBApi;

use App\Actions\Api\UpdateApiVersion;
use App\Enums\ItemCategorieEnum;
use Illuminate\Support\Facades\Http;

final class UpdateItemsFromDofusDBApi
{
    /**
     * @return string[]
     *
     * @throws \JsonException
     */
    // Action qui va pour chaque types d'item, lancer une autre action qui va get et save les items qu'il nous manque
    public function __invoke(): array
    {
        $newItems = [];

        // Lance un changement, on lui donne dans l'ordre, le model lié (hat, cloak...), les typesID normaux et typesID d'apparât
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)([16], [246], ItemCategorieEnum::HAT->value));
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)([17], [247], ItemCategorieEnum::CAPE->value));
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)([82], [248], ItemCategorieEnum::SHIELD->value));
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)([], [199], ItemCategorieEnum::COSTUME->value));
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)([], [299], ItemCategorieEnum::SHOULDERPADS->value));
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)([], [300], ItemCategorieEnum::WINGS->value));
        $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)([18, 121], [190, 255, 256, 249, 250], ItemCategorieEnum::PET->value));
        $newItems = array_merge($newItems, (new SaveHavenBagsFromDofusDB)('images/icons/heaven_bags'));

        // Cette ligne fetch les DD, Muldo et Volkorne, ils ne changeront pas, donc pas besoin de la relancer
        // $newItems = array_merge($newItems, (new SaveItemsFromDofusDB)([97, 196, 207], [], ItemCategorieEnum::PET->value));

        // Sauvegarde la nouvelle version dans notre fichier
        $newVersion = Http::get('https://api.dofusdb.fr/version')->body();

        (new UpdateApiVersion)('dofusDB', $newVersion);

        return $newItems;
    }
}
