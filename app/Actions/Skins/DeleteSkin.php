<?php

declare(strict_types=1);

namespace App\Actions\Skins;

use App\Models\Skin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class DeleteSkin
{
    // Need update
    public function __invoke($skinId)
    {
        Skin::find($skinId)->delete();
    }
}
