<?php

declare(strict_types=1);

namespace App\Actions\Api;

use Illuminate\Support\Facades\Storage;

final class FetchExternalFile
{
    // Need update
    public function __invoke(
        $url,
        $storage
    ): void {

        $file = file_get_contents($url);
        Storage::put($storage, $file);
    }
}
