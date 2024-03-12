<?php

declare(strict_types=1);

namespace App\Actions\DofusDBApi;

use App\Actions\Api\CheckApiVersion;
use Illuminate\Support\Facades\Http;

final class CheckDofusDBUpdate
{
    // Need update
    public function __invoke(): bool
    {
        // Get la version de l'api
        $response = Http::get('https://api.beta.dofusdb.fr/version');

        // Si aucune réponse, on dit qu'elle est à jour
        if ($response->status() != 200) {
            return false;
        }

        $version = $response->body();

        // Get notre version de l'api
        $currentVersion = (new CheckApiVersion)()->dofusDB;

        // Return si on a une différence entre les deux ou non
        return $currentVersion != $version;
    }
}
