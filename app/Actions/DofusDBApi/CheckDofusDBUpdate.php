<?php

declare(strict_types=1);

namespace App\Actions\DofusDBApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

final class CheckDofusDBUpdate
{
    // Need update
    public function __invoke(): bool{

        // Get la version de l'api
        $response = Http::get('https://api.dofusdb.fr/version');

        // Si aucune réponse, on dit false pour pas spam l'api pour rien
        if($response->getStatusCode() != 200) {
            return false;
        }

        $version = $response->body();

        // Get notre version de l'api
        $currentVersionJson = Storage::disk('local')->get('dofusdb_api_version.json');
        $currentVersion = json_decode($currentVersionJson)->version;

        // Return si on a une différence entre les deux ou non
        return $currentVersion != $version;
    }
}
