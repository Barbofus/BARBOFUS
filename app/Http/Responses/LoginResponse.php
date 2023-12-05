<?php

namespace App\Http\Responses;

use App\Models\Like;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @return mixed
     */
    public function toResponse($request)
    {
        // Si l'email est vérifié, connecte
        if (auth()->user()->hasVerifiedEmail()) {

            // Ajoute l'ip de l'utilisateur à tous les likes de son ID, et inversement
            Like::where('user_id', auth()->id())->update(['ip_adress' => request()->ip()]);
            Like::where('ip_adress', request()->ip())->update(['user_id' => auth()->id()]);

            return redirect()->route('home');
        }

        // Sinon envoie le mail de vérification, puis déconnecte
        $id = auth()->id();

        auth()->user()->sendEmailVerificationNotification();

        auth()->logout();

        return redirect()->route('verification.notice', ['id' => $id]);
    }
}
