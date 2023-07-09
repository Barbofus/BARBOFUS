<?php

declare(strict_types=1);

namespace App\Actions\Api;

use Illuminate\Support\Facades\Storage;
use stdClass;

final class CheckApiVersion
{
    // Need update
    public function __invoke(): stdClass
    {

        // Get nos versions des Api
        $versions = Storage::disk('local')->get('api_versions.json');

        return json_decode($versions);
    }
}
