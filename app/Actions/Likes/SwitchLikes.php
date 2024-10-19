<?php

declare(strict_types=1);

namespace App\Actions\Likes;

use App\Models\Like;
use App\Models\UnityLike;
use Illuminate\Support\Facades\Auth;

final class SwitchLikes
{
    /**
     * @return void
     */
    public function __invoke(int $skinID, bool $isUnity = false)
    {
        $ipAdress = request()->ip();

        // Si user connecté, on check par user_id
        if (auth()->check()) {

            // Si on a déjà like le skin
            if (! $isUnity) {
                if ($liked = Auth::user()->Likes()->where('skin_id', $skinID)->first()) {
                    $liked->delete();

                    return;
                }
            } else {
                if ($liked = Auth::user()->UnityLikes()->where('unity_skin_id', $skinID)->first()) {
                    $liked->delete();

                    return;
                }
            }
        }

        // Si on a déjà like le skin par ip
        /*if ($liked = Like::where('skin_id', $skinID)->where('ip_adress', $ipAdress)->first()) {
            $liked->delete();

            return;
        }*/

        if (! $isUnity) {
            // Si aucun like trouvé, ont le créé
            Like::create([
                'skin_id' => $skinID,
                'user_id' => auth()->check() ? Auth::id() : null,
                'ip_adress' => $ipAdress,
            ]);
        } else {
            // Si aucun like trouvé, ont le créé
            UnityLike::create([
                'unity_skin_id' => $skinID,
                'user_id' => auth()->check() ? Auth::id() : null,
                'ip_adress' => $ipAdress,
            ]);
        }
    }
}
