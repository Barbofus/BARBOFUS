<?php

namespace App\Jobs;

use App\Models\UnitySkin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class IncrementViewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $skinId,
        public string $viewType,
        public ?string $userId = null,
        public ?string $sessionId = null
    ) {}

    public function handle(): void
    {
        // Créer un identifiant unique pour éviter les doublons
        $uniqueId = $this->userId ?? $this->sessionId ?? request()->ip();
        $cacheKey = "viewed_skin_{$this->skinId}_{$this->viewType}_{$uniqueId}";

        // Éviter les vues multiples dans la même heure
        if (Cache::has($cacheKey)) {
            return;
        }

        $skin = UnitySkin::find($this->skinId);
        if (!$skin) {
            return;
        }

        // Incrémenter selon le type de vue
        if ($this->viewType === 'chunk') {
            $skin->incrementChunkViews();
        } elseif ($this->viewType === 'detailed') {
            $skin->incrementDetailedViews();
        }

        // Marquer comme vu pendant 1 heure
        //Cache::put($cacheKey, true, 3600);
    }
}
