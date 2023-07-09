<?php

declare(strict_types=1);

namespace App\Actions\Api;

use Illuminate\Support\Facades\Storage;

final class UpdateApiVersion
{
    // Need update
    public function __invoke(
        $apiName,
        $newVersion,
    ): void {

        // Get nos versions des Api
        $file = Storage::disk('local')->get('api_versions.json');
        $versions = (array) json_decode($file);

        $versions[$apiName] = $newVersion;

        Storage::disk('local')->put('api_versions.json', json_encode($versions));
    }
}
