<?php

declare(strict_types=1);

namespace App\Actions\Likes;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

final class SwitchLikes
{
    /**
     * @return void
     */
    public function __invoke(int $skinID)
    {
        // Si on a déjà like le skin
        if ($liked = Auth::user()->Likes()->where('skin_id', $skinID)->first()) {
            $liked->delete();

            return;
        }

        // Sinon, ont le créé
        Like::create([
            'skin_id' => $skinID,
            'user_id' => Auth::id(),
        ]);
    }
}
