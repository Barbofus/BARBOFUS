<?php

declare(strict_types=1);

namespace App\Actions\Skins;

use App\Models\UnitySkin;
use Illuminate\Support\Facades\Cache;

final class IncrementView
{
    /**
     * @return void
     */
    public function __invoke(
        int $skinId,
        ?string $userId = null,
        ?string $sessionId = null
    ) {
        // Créer un identifiant unique pour éviter les doublons
        $uniqueId = $userId ?? $sessionId ?? request()->ip();
        $cacheKey = "viewed_skin_{$skinId}_{$uniqueId}";

        // Éviter les vues multiples dans la même heure
        if (Cache::has($cacheKey)) {
            return;
        }

        $skin = UnitySkin::find($skinId);
        if (!$skin) {
            return;
        }

        // Incrémenter une vue détaillés
        $skin->incrementDetailedViews();

        // Marquer comme vu pendant 1 heure
        Cache::put($cacheKey, true, 3600);
    }
}
