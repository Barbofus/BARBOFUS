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
            Like::where('user_id', auth()->id())->update(['ip_adress' => request()->header('X-Forwarded-For') ?? request()->ip()]);
            Like::where('ip_adress', request()->header('X-Forwarded-For') ?? request()->ip())->update(['user_id' => auth()->id()]);

            // Connexion via Tougli
            if ($request->get('redirect') !== null) {

                $redirect = $request->get('redirect');

                $parsed = parse_url($redirect);

                if (! $parsed || ! isset($parsed['host'])) {
                    abort(403);
                }

                $host = $parsed['host'];

                $baseDomain = 'barbofus.com';

                $isAllowed = false;

                // Autorise domaine principal
                if ($host === $baseDomain) {
                    $isAllowed = true;
                }

                // Autorise sous-domaines
                if (str_ends_with($host, '.'.$baseDomain)) {
                    $isAllowed = true;
                }

                // Autorise localhost strictement
                if (in_array($host, ['localhost', '127.0.0.1'])) {
                    $isAllowed = true;
                }

                if (! $isAllowed) {
                    abort(403, 'Invalid redirect host');
                }

                return redirect()->to($redirect);
            }

            return redirect()->route('home');
        }

        // Sinon envoie le mail de vérification, puis déconnecte
        $id = auth()->id();

        auth()->user()->sendEmailVerificationNotification();

        auth()->logout();

        return redirect()->route('verification.notice.show', ['id' => $id]);
    }
}
