<?php

declare(strict_types=1);

namespace App\Actions\Api;

use Illuminate\Support\Facades\Http;
use stdClass;

final class GetApiBody
{
    // Need update
    public function __invoke(
        $url
    ): stdClass {

        // Récupère les datas
        $response = Http::get($url);

        // Si aucune réponse, on dit false pour pas spam l'api pour rien
        if ($response->getStatusCode() != 200) {
            return [];
        }

        // Return si on a une différence entre les deux ou non
        return json_decode($response->body());
    }
}
