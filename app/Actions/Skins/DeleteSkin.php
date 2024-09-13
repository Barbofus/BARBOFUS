<?php

declare(strict_types=1);

namespace App\Actions\Skins;

use App\Models\Skin;
use App\Models\UnitySkin;
use Illuminate\Support\Facades\Storage;

final class DeleteSkin
{
    /**
     * @return void
     */
    public function __invoke(int $skinId, bool $isUnitySkin = false)
    {
        $skin = $isUnitySkin ? UnitySkin::find($skinId) : Skin::find($skinId);

        if (Storage::exists($skin->image_path)) {
            Storage::delete($skin->image_path);
        }

        $skin->delete();
    }
}
