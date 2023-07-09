<?php

declare(strict_types=1);

namespace App\Actions\Api;

use Illuminate\Support\Facades\Storage;

final class UpdateApiVersion
{
    public function __invoke(
        string $apiName,
        string $newVersion,
    ): void {

        // Get nos versions des Api
        $file = Storage::disk('local')->get('api_versions.json');
        $versions = (array) json_decode($file);

        $versions[$apiName] = $newVersion;

        Storage::disk('local')->put('api_versions.json', json_encode($versions));
    }
}
