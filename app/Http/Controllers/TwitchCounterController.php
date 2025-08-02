<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TwitchCounterController extends Controller
{
    private $secret;

    public function __construct()
    {
        $this->secret = config('services.twitch_counter_secret');
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Validation basique
        $request->validate([
            'name' => 'required|string',
            'action' => 'required|string|in:increment,decrement,set,read',
            'value' => 'nullable|integer',
            'key' => 'required|string',
        ]);

        // Vérification de la clé secrète
        if ($request->key !== $this->secret) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Récupération des compteurs
        $counters = json_decode(Storage::disk('local')->get('json/twitch_counters.json'), true) ?? [];

        $name = $request->name;

        // Initialisation si nécessaire
        if (! isset($counters[$name])) {
            $counters[$name] = 0;
        }

        // Application de l'action
        if ($request->action === 'increment') {
            $counters[$name]++;
        } elseif ($request->action === 'decrement') {
            $counters[$name]--;
        } elseif ($request->action === 'set') {
            $counters[$name] = (int) $request->value;
        } elseif ($request->action === 'read') {
            return response()->json([
                'value' => $counters[$name],
            ]);
        }

        // Sauvegarde
        Storage::disk('local')->put('json/twitch_counters.json', json_encode($counters));

        return response()->json([
            'value' => $counters[$name],
        ]);
    }
}
