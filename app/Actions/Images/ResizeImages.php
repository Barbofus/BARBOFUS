<?php

declare(strict_types=1);

namespace App\Actions\Images;

use Intervention\Image\Facades\Image;

final class ResizeImages
{
    /**
     * @param  array<string, int>  $newSize
     */
    public function __invoke(
        mixed $image,
        string $storagePath,
        $newSize,
    ): string {

        // Nomme l'image en fonction de l'heure actuelle
        $imageName = time().'.'.$image->getClientOriginalExtension();

        // On range ça dans le public
        $destinationPath = storage_path('app/public/'.$storagePath);

        // Créationd de l'image avec Intervention Image
        $img = Image::make($image->getRealPath());

        // On resize suivant la taille désiré
        $img->resize($newSize['width'], $newSize['height'], function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destinationPath.'/'.$imageName);

        // On return le chemin d'accés
        return 'images/skins/'.$imageName;
    }
}
