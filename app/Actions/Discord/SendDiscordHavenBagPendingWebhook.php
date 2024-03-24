<?php

declare(strict_types=1);

namespace App\Actions\Discord;

use App\Models\HavenBag;
use Illuminate\Support\Facades\Http;

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

        Http::post($url, $body);
    }
}
