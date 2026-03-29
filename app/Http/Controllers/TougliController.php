<?php

namespace App\Http\Controllers;

use App\Enums\LocaleEnum;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class TougliController extends Controller
{
    /**
     * Get current user information with JWT token.
     */
    public function whoami(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => __('barbofus.errorUnauthenticated')], 401);
        }

        if ($user->email_verified_at === null) {
            return response()->json(['error' => __('barbofus.errorEmailNotVerified')], 401);
        }

        $payload = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->rolesName(),
            'locale' => $user->locale,
            'exp' => time() + 86400,
        ];

        $jwt = JWT::encode($payload, config('app.jwt_secret'), 'HS256');

        return response()->json(['token' => $jwt], 200);
    }

    /**
     * Update user locale and return updated JWT token.
     */
    public function updateLocale(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => __('barbofus.errorUnauthenticated')], 401);
        }

        if ($user->email_verified_at === null) {
            return response()->json(['error' => __('barbofus.errorEmailNotVerified')], 401);
        }

        $validated = $request->validate([
            'locale' => 'required|string|in:' . implode(',', LocaleEnum::values()),
        ]);

        // Mettre à jour la locale de l'utilisateur
        $user->update(['locale' => $validated['locale']]);

        // Définir la locale pour l'application
        app()->setLocale($validated['locale']);

        // Générer un nouveau JWT avec la locale mise à jour
        $payload = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->rolesName(),
            'locale' => $user->locale,
            'exp' => time() + 86400,
        ];

        $jwt = JWT::encode($payload, config('app.jwt_secret'), 'HS256');

        return response()->json([
            'message' => 'Locale updated successfully',
            'token' => $jwt,
            'locale' => $user->locale
        ], 200);
    }

    /**
     * Logout the user and redirect (cross-site support).
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirect = $request->query('redirect');

        if ($redirect) {
            $host = parse_url($redirect, PHP_URL_HOST);
            $baseDomain = 'barbofus.com';

            $isAllowed = $host === $baseDomain
                || str_ends_with($host, '.' . $baseDomain)
                || in_array($host, ['localhost', '127.0.0.1']);

            if ($isAllowed) {
                return redirect()->to($redirect);
            }
        }

        return redirect()->route('home');
    }
}
