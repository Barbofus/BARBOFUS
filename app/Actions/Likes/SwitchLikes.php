<?php

declare(strict_types=1);

namespace App\Actions\Likes;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

final class SwitchLikes
{
    // Need update
    public function __invoke($skin)
    {
        // Si on a déjà like le skin
        if ($liked = Auth::user()->Likes()->where('skin_id', $skin)->first()) {
            $liked->delete();

            return;
        }

        // Sinon, ont le créé
        Like::create([
            'skin_id' => $skin,
            'user_id' => \Auth::user()->id,
        ]);
    }
}
