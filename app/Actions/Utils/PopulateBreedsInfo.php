<?php

declare(strict_types=1);

namespace App\Actions\Utils;

use App\Models\Race;
use Illuminate\Support\Facades\Storage;

final class PopulateBreedsInfo
{
    public function __invoke(): void
    {
        // Charge les fichiers de classes
        $breedsFile = Storage::disk('local')->get('json/skinator/BreedsRoot.json');
        $breedsJson = json_decode($breedsFile, true);

        // Charge les fichiers des visages
        $headsFile = Storage::disk('local')->get('json/skinator/HeadsRoot.json');
        $headsJson = json_decode($headsFile, true);

        // Prépare nos tableaux qui finiront en BDD
        $colorsArray = [];
        $headsArray = [];

        /*
         * Récupère toutes les couleurs initiales des classes
         */
        foreach ($breedsJson['references']['RefIds'] as $breed) {
            $colorsArray[$breed['data']['id']]['male'] = $breed['data']['maleColors']['Array'];
            $colorsArray[$breed['data']['id']]['female'] = $breed['data']['femaleColors']['Array'];
        }

        /*
         * Récupère tous les visages des classes
         */
        foreach ($headsJson['references']['RefIds'] as $head) {
            // dd($head['data']);
            $headsArray[$head['data']['breed']][($head['data']['gender']) ? 'female' : 'male'][$head['data']['order']]['skins'] = $head['data']['skins'];
            $headsArray[$head['data']['breed']][($head['data']['gender']) ? 'female' : 'male'][$head['data']['order']]['id'] = $head['data']['id'];
            $headsArray[$head['data']['breed']][($head['data']['gender']) ? 'female' : 'male'][$head['data']['order']]['assetId'] = $head['data']['assetId'];
        }

        $breeds = Race::all();

        foreach ($breeds as $breed) {
            $jsonColors = json_encode($colorsArray[$breed->dofus_id]);
            $jsonHeads = json_encode($headsArray[$breed->dofus_id]);

            $breed->update([
                'colors' => $jsonColors,
                'heads' => $jsonHeads,
            ]);
        }

        dd('DONE');
    }
}
