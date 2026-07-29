<?php

namespace App\Http\Controllers;

use App\Enums\LocaleEnum;
use App\Models\Race;
use App\Models\UnitySkin;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TougliController extends Controller
{
    /**
     * Get current user information with JWT token.
     */
    public function whoami(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
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
    public function updateLocale(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['error' => __('barbofus.errorUnauthenticated')], 401);
        }

        if ($user->email_verified_at === null) {
            return response()->json(['error' => __('barbofus.errorEmailNotVerified')], 401);
        }

        $validated = $request->validate([
            'locale' => 'required|string|in:'.implode(',', LocaleEnum::values()),
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
            'locale' => $user->locale,
        ], 200);
    }

    /**
     * Get all unity skins of the authenticated user for a given Dofus class ID.
     * Used by Tougli to let the user pick a skin matching their character's class.
     *
     * Query param: classDofusId (int) — the Dofus ID of the class (same as characters.class_id on Tougli)
     */
    public function getSkins(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['error' => __('barbofus.errorUnauthenticated')], 401);
        }

        $classDofusId = $request->query('classDofusId');

        // Construire la requête de base
        $query = UnitySkin::where('user_id', $user->id)
            ->select('id', 'name', 'image_path')
            ->orderBy('created_at', 'desc');

        // Si classDofusId est fourni, filtrer par race
        // unity_skins.race_id stocke le dofus_id de la table races (pas le PK)
        if ($classDofusId && is_numeric($classDofusId)) {
            $query->where('race_id', (int) $classDofusId);
        }

        $skins = $query->get();

        return response()->json(['data' => $skins]);
    }

    /**
     * Get a random sample of public skins from the global gallery for a given Dofus class ID.
     * Used by Tougli as a fallback when the user has no personal skins for their class.
     *
     * Query param: classDofusId (int, required) — the Dofus ID of the class
     * Query param: limit (int, optional, default 12) — number of skins to return
     * No auth required.
     */
    public function getGlobalSkins(Request $request): JsonResponse
    {
        $classDofusId = $request->query('classDofusId');
        $limit = min((int) ($request->query('limit', 12)), 50);

        if (! $classDofusId || ! is_numeric($classDofusId)) {
            return response()->json(['error' => 'classDofusId is required and must be an integer'], 422);
        }

        // unity_skins.race_id stocke le dofus_id de la table races (pas le PK)
        // Vérifier que la race existe bien
        if (! Race::where('dofus_id', (int) $classDofusId)->exists()) {
            return response()->json(['data' => []]);
        }

        // Optimisation : on prend les 100 derniers skins (index sur id, rapide)
        // et on en tire un échantillon aléatoire côté PHP — évite ORDER BY RAND() sur 50k lignes.
        $pool = UnitySkin::where('race_id', (int) $classDofusId)
            ->select('id', 'name', 'image_path')
            ->latest('id')
            ->limit(100)
            ->get()
            ->shuffle()
            ->take($limit);

        return response()->json(['data' => $pool->values()]);
    }

    /**
     * Return a single UnitySkin as JSON (id, name, image_path, race_id).
     * race_id contains the dofus_id of the class (same as characters.class_id on Tougli).
     * Used by Tougli to resolve the saved barbofusSkinId after a page reload,
     * and to validate that a manually entered skin matches the character's class.
     * No auth required.
     */
    public function getSkinById(int $id): JsonResponse
    {
        $skin = UnitySkin::select('id', 'name', 'image_path', 'race_id')->find($id);

        if (! $skin) {
            return response()->json(['error' => 'Skin not found'], 404);
        }

        // Retourner un tableau explicite pour garantir que tous les champs sont présents,
        // notamment race_id qui stocke le dofus_id de la classe (= characters.class_id sur Tougli).
        return response()->json([
            'data' => [
                'id' => $skin->id,
                'name' => $skin->name,
                'image_path' => $skin->image_path,
                'race_id' => $skin->race_id,
            ],
        ]);
    }

    /**
     * Redirect to the actual image of a UnitySkin by its ID.
     * Used by Tougli to resolve custom skin inputs (URL or plain numeric ID).
     * No auth required.
     */
    public function getSkinImage(int $id): JsonResponse|RedirectResponse
    {
        $skin = UnitySkin::select('image_path')->find($id);

        if (! $skin) {
            return response()->json(['error' => 'Skin not found'], 404);
        }

        return redirect()->to(asset('storage/'.$skin->image_path));
    }

    /**
     * Logout the user and redirect (cross-site support).
     */
    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirect = $request->query('redirect');

        if ($redirect) {
            $host = parse_url($redirect, PHP_URL_HOST);
            $baseDomain = 'barbofus.com';

            $isAllowed = $host === $baseDomain
                || str_ends_with(''.$host, '.'.$baseDomain)
                || in_array($host, ['localhost', '127.0.0.1']);

            if ($isAllowed) {
                return redirect()->to($redirect);
            }
        }

        return redirect()->route('home');
    }
}
