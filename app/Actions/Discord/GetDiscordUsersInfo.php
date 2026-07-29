<?php

declare(strict_types=1);

namespace App\Actions\Discord;

use App\Models\Connection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

final class GetDiscordUsersInfo
{
    /**
     * Récupère les informations Discord pour plusieurs utilisateurs de manière optimisée
     *
     * @param  Collection<int, int>  $userIds
     * @return array<int, mixed|null>
     */
    public function __invoke(Collection $userIds): array
    {
        // Récupérer toutes les connexions Discord pour les utilisateurs donnés
        $connections = Connection::query()
            ->where('name', 'discord')
            ->whereIn('user_id', $userIds->toArray())
            ->get()
            ->keyBy('user_id');

        $discordInfos = [];

        foreach ($userIds as $userId) {
            $connection = $connections->get($userId);

            if (! $connection) {
                $discordInfos[$userId] = null;

                continue;
            }

            // Essayer de récupérer les infos Discord
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$connection->access_token,
            ])->get('https://discordapp.com/api/users/@me');

            if ($response->status() === 200) {
                $discordInfos[$userId] = json_decode($response->body(), true);
            } else {
                // Si le token a expiré, tenter de le refresher
                $refreshedInfo = (new RefreshDiscordToken)($userId);
                $discordInfos[$userId] = $refreshedInfo;
            }
        }

        return $discordInfos;
    }
}
