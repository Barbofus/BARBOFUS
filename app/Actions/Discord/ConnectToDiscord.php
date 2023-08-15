<?php

declare(strict_types=1);

namespace App\Actions\Discord;

use App\Models\Connection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

final class ConnectToDiscord
{
    /**
     * @return void|Connection
     */
    public function __invoke(string $code)
    {
        // Créer le body à envoyer
        $payload = [
            'code' => $code,
            'client_id' => config('app.discord_connection_id'),
            'client_secret' => config('app.discord_connection_secret'),
            'grant_type' => 'authorization_code',
            'redirect_uri' => config('app.discord_redirect_uri'),
            'scope' => 'identify',
        ];

        $discord_token_url = 'https://discord.com/api/oauth2/token';

        // Envoie les infos à discord pour récupèrer les tokens
        $response = Http::asForm()->post($discord_token_url, $payload);

        if ($response->status() === 200) {
            $result = json_decode($response->body(), true);

            // Si la connection existe déjà, la supprime pour la recréer
            if (count(Connection::query()->where('name', 'discord')->where('user_id', Auth::id())->get()) > 0) {
                Connection::query()->where('name', 'discord')->where('user_id', Auth::id())->delete();
            }

            // Créer la connection
            return Connection::create([
                'user_id' => Auth::id(),
                'name' => 'discord',
                'access_token' => $result['access_token'],
                'refresh_token' => $result['refresh_token'],
            ]);
        }
    }
}
