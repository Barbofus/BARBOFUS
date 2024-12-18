<?php

declare(strict_types=1);

namespace App\Actions\Api;

use Exception;
use Illuminate\Support\Facades\Storage;

final class FetchExternalFile
{
    public function __invoke(
        string $url,
        string $storage
    ): bool {

        try {
            $file = file_get_contents($url);

            if ($file === false) {
                return false;
            }

            return Storage::put($storage, $file);
        } catch (Exception $e) {
            return false;
        }
    }
}
