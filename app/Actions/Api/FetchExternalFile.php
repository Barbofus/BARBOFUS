<?php

declare(strict_types=1);

namespace App\Actions\Api;

use Illuminate\Support\Facades\Storage;

final class FetchExternalFile
{
    public function __invoke(
        string $url,
        string $storage
    ): void {

        $file = file_get_contents($url);
        Storage::put($storage, $file);
    }
}
