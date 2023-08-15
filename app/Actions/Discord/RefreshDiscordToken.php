<?php

declare(strict_types=1);

namespace App\Actions\Discord;

use App\Models\Connection;
use Illuminate\Support\Facades\Http;

final class RefreshDiscordToken
{
    /**
     * @return mixed|null
     */
    public function __invoke(int $user)
    {
        $co = Connection::where('user_id', $user)->where('name', 'discord')->take(1)->get()->toArray();

        // Créer le body à envoyer
        $payload = [
            'client_id' => config('app.discord_connection_id'),
            'client_secret' => config('app.discord_connection_secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $co[0]['refresh_token'],
        ];

        $discord_token_url = 'https://discord.com/api/oauth2/token';

        // Envoie les infos à discord pour récupèrer les tokens
        $response = Http::asForm()->post($discord_token_url, $payload);

        if ($response->status() === 200) {
            $result = json_decode($response->body(), true);

            // Update la connection discord actuel
            $co = Connection::query()->where('name', 'discord')->where('user_id', $user);

            $co->update([
                'access_token' => $result['access_token'],
                'refresh_token' => $result['refresh_token'],
            ]);

            // Récupère les infos et les return
            $discord_users_url = 'https://discordapp.com/api/users/@me';

            // Envoie les infos à discord pour récupèrer les tokens
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$result['access_token'],
            ])->get($discord_users_url);

            // Si on a le résultat, on le return
            if ($response->status() === 200) {
                return json_decode($response->body(), true);
            }
        }

        return null;
    }
}
