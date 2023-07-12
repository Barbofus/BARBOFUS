<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;
use Laravel\Fortify\Fortify;

class EmailVerificationPromptController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return VerifyEmailViewResponse|RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        return $user->hasVerifiedEmail()
            ? redirect()->intended(Fortify::redirects('email-verification'))
            : app(VerifyEmailViewResponse::class);
    }

    /**
     * @return JsonResponse|RedirectResponse
     */
    public function store(Request $request)
    {
        $user = User::findOrFail($request->id);
        if ($user->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new JsonResponse('', 204)
                : redirect()->intended(Fortify::redirects('email-verification'));
        }

        $user->sendEmailVerificationNotification();

        return $request->wantsJson()
            ? new JsonResponse('', 202)
            : back()->with('status', Fortify::VERIFICATION_LINK_SENT);
    }
}
