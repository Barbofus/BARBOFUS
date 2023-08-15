<?php

declare(strict_types=1);

namespace App\Actions\Discord;

use App\Models\Connection;
use Illuminate\Support\Facades\Http;

final class GetDiscordUserInfo
{
    /**
     * @return mixed|null
     */
    public function __invoke(int $user)
    {
        if (Connection::query()->where('user_id', $user)->where('name', 'discord')->count() == 0) {
            return null;
        }

        $discord_users_url = 'https://discordapp.com/api/users/@me';
        $co = Connection::query()->where('user_id', $user)->where('name', 'discord')->take(1)->get()->toArray();

        // Envoie les infos à discord pour récupèrer les tokens
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$co[0]['access_token'],
        ])->get($discord_users_url);

        // Si on a le résultat, on le return
        if ($response->status() === 200) {
            return json_decode($response->body(), true);
        }

        // Sinon, on tente de refresh le token et on recommence
        return (new RefreshDiscordToken)($user);
    }
}
