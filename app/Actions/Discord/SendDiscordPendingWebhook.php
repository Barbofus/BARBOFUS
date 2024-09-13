<?php

declare(strict_types=1);

namespace App\Actions\Discord;

use App\Jobs\SendDiscordWebhook;
use App\Models\Skin;
use App\Models\UnitySkin;

final class SendDiscordPendingWebhook
{
    /**
     * @return void
     */
    public function __invoke(string $url, Skin|UnitySkin $skin)
    {
        $body = [
            'embeds' => [
                [
                    'description' => 'Nouveau skin en attente.
                        [Clique pour le vérifier]('.route('user-dashboard.index', 'section=skins-validation').')

                        **'.$skin->User->name.'**
                        *'.ucfirst(\Carbon\Carbon::now()->isoFormat('dddd D MMMM à HH:mm')).'*',
                    'color' => 16562499,
                    'thumbnail' => [
                        'url' => asset('storage/'.$skin->image_path),
                    ],
                ],
            ],
        ];

        dispatch(new SendDiscordWebhook($url, $body));
    }
}
