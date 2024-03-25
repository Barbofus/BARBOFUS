<?php

declare(strict_types=1);

namespace App\Actions\Discord;

use App\Jobs\SendDiscordWebhook;
use App\Models\HavenBag;

final class SendDiscordHavenBagPendingWebhook
{
    /**
     * @return void
     */
    public function __invoke(string $url, HavenBag $havenBag)
    {
        $body = [
            'embeds' => [
                [
                    'description' => 'Nouveau havre-sac en attente.
                        [Clique pour le vérifier]('.route('user-dashboard.index', 'section=haven-bags-validation').')

                        **'.$havenBag->user->name.'**
                        *'.ucfirst(\Carbon\Carbon::now()->isoFormat('dddd D MMMM à HH:mm')).'*',
                    'color' => 16562499,
                ],
            ],
        ];

        dispatch(new SendDiscordWebhook($url, $body));
    }
}
