<?php

declare(strict_types=1);

namespace App\Actions\Skins;

use App\Models\Skin;
use Illuminate\Support\Facades\Storage;

final class DeleteSkin
{
    // Need update
    public function __invoke($skinId)
    {
        $skin = Skin::find($skinId);

        if(Storage::exists($skin->image_path))
            Storage::delete($skin->image_path);

        $skin->delete();
    }
}
