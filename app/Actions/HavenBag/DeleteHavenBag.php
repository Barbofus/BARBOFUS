<?php

declare(strict_types=1);

namespace App\Actions\HavenBag;

use App\Models\HavenBag;
use Illuminate\Support\Facades\Storage;

final class DeleteHavenBag
{
    /**
     * @return void
     */
    public function __invoke(int $havenBagID)
    {
        $havenBag = HavenBag::find($havenBagID);

        if (Storage::exists($havenBag->image_path)) {
            Storage::delete($havenBag->image_path);
        }

        $havenBag->delete();
    }
}
