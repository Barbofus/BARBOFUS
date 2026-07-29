<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Http\Responses\RegisterResponse as FortifyRegisterResponse;

class RegisterResponse extends FortifyRegisterResponse
{
    protected mixed $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function toResponse($request)
    {
        $id = auth()->id();
        auth()->user()->update(['locale' => app()->getLocale()]);
        $this->guard->logout();

        return redirect()->route('verification.notice.show', ['id' => $id]);
    }
}
