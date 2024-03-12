<?php

declare(strict_types=1);

namespace App\Actions\DofusDBApi;

use App\Actions\Api\FetchExternalFile;
use App\Models\HeavenBagTheme;

final class SaveHeavenBagsFromDofusDB
{
    /**
     * @return array<int<0, max>, mixed>
     */
    // Action qui va déterminer si on a déjà l'item ou non, puis l'enregistrer, get les items depuis une autre action
    public function __invoke(
        string $imagePath,
    ): array {

        $newItems = [];

        // Action qui récupère les items contenus dans les typesID entré
        $items = (new GetHeavenBagsFromDofusDB)();

        // Parcour tous les items récupérés
        foreach ($items as $item) {

            // Si on l'a déjà, passe à la boucle suivante
            if (HeavenBagTheme::where('dofus_id', '=', $item['id'])->exists()) {
                continue;
            }

            // Créer l'item en bdd
            $newItem = HeavenBagTheme::create([
                'name' => $item['name'],
                'dofus_id' => $item['id'],
                'image_path' => 'images/icons/heaven_bags/backgrounds/'. $item['mapId'] .'.jpg',
                'popocket_icon_path' => 'images/icons/heaven_bags/popockets/'. $item['popocket_iconId'] .'.png',
            ]);

            // Récupère l'image et la stocke dans l'icon_path
            (new FetchExternalFile)($item['image_path'], $newItem['image_path']);
            (new FetchExternalFile)($item['popocket_icon_path'], $newItem['popocket_icon_path']);

            // Sauvegarde les nouveautés pour les montrer après la MAJ
            $newItems[] = [
                'Havre-Sac '. $newItem->name,
                $newItem->popocket_icon_path,
            ];
        }

        return $newItems;
    }
}
