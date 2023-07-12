<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\VerifyEmailResponse;

class VerifyEmailController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return VerifyEmailResponse|RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return app(VerifyEmailResponse::class);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        session()->flash('alert-message', 'Ton email, '.$user->email.' a été validé, tu peux te connecter et profiter pleinement de Barbofus !');

        return redirect()->route('login');
    }
}
