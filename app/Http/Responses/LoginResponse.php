<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @return mixed
     */
    public function toResponse($request)
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $id = auth()->id();

        auth()->user()->sendEmailVerificationNotification();

        auth()->logout();

        return redirect()->route('verification.notice', ['id' => $id]);
    }
}
