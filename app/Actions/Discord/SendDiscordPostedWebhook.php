<?php

declare(strict_types=1);

namespace App\Actions\Discord;

use App\Models\Skin;
use Illuminate\Support\Facades\Http;

final class SendDiscordPostedWebhook
{
    /**
     * @return void
     */
    public function __invoke(string $url, Skin $skin)
    {
        $body = [
            'embeds' => [
                [
                    'description' => 'Nouveau skin en ligne sur [Barbofus]('.route('home').').
                        [Clique pour aller le voir]('.route('skins.show', $skin).')

                        *Posté par* **'.$skin->User->name.'**',
                    'color' => 16562499,
                    'image' => [
                        'url' => asset('storage/'.$skin->image_path),
                    ],
                ],
            ],
        ];

        Http::post($url, $body);
    }
}
