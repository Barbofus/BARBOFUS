<?php

declare(strict_types=1);

namespace App\Actions\Discord;

use App\Jobs\SendDiscordWebhook;
use App\Models\Skin;
use App\Models\UnitySkin;

final class SendDiscordPostedWebhook
{
    /**
     * @return void
     */
    public function __invoke(string $url, Skin|UnitySkin $skin, bool $isUnitySkin = false)
    {
        $body = [
            'embeds' => [
                [
                    'description' => 'Nouveau skin en ligne sur [Barbofus]('.route('home').').
                        [Clique pour aller le voir]('.route(($isUnitySkin) ? 'unity-skins.show' : 'skins.show', $skin).')

                        *Posté par* **'.$skin->User->name.'**',
                    'color' => 16562499,
                    'image' => [
                        'url' => asset('storage/'.$skin->image_path),
                    ],
                ],
            ],
        ];

        dispatch(new SendDiscordWebhook($url, $body));
    }
}
