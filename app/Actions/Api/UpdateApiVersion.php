<?php

declare(strict_types=1);

namespace App\Actions\Api;

use Illuminate\Support\Facades\Storage;

final class UpdateApiVersion
{
    /**
     * @throws \JsonException
     */
    public function __invoke(
        string $apiName,
        string $newVersion,
    ): void {

        // Get nos versions des Api
        $file = Storage::disk('local')->get('json/api_versions.json');
        $versions = (array) json_decode($file);

        $versions[$apiName] = $newVersion;

        Storage::disk('local')->put('json/api_versions.json', json_encode($versions, JSON_THROW_ON_ERROR));
    }
}
