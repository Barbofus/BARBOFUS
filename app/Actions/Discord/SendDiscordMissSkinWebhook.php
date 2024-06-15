<?php

declare(strict_types=1);

namespace App\Actions\Discord;

use App\Models\Skin;
use App\Models\SkinWinner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

final class SendDiscordMissSkinWebhook
{
    /**
     * @param  array<int, Skin>  $topTen
     * @return void
     */
    public function __invoke(string $url, $topTen)
    {
        $winners = SkinWinner::query()
            ->addSelect([
                'skin_image_path' => DB::table('skins')
                    ->select('image_path')
                    ->whereColumn('id', 'skin_winners.skin_id')
                    ->take(1),
            ])
            ->orderBy('reward_id', 'ASC')
            ->get();

        $body = [
            'embeds' => [
                [
                    'title' => '1ère place - Ocre',
                    'description' => 'Bravo à ***'.$winners[0]['user_name'].'***, :crown: grand
                        vainqueur de ce *Miss\'Skin* :kiss:
                        Avec '.$winners[0]['weekly_likes'].' :sparkling_heart:
                        [Aller sur la page du skin]('.route('skins.show', $winners[0]['skin_id']).')',
                    'color' => 16562499,
                    'image' => [
                        'url' => asset('storage/'.$winners[0]['skin_image_path']),
                    ],
                    'thumbnail' => [
                        'url' => asset('storage/images/misc_ui/dofus_ocre.png'),
                    ],
                ],
                [
                    'title' => '2ème place - Émeraude',
                    'description' => 'Bravo à ***'.$winners[1]['user_name'].'***, :trophy: pour cet
                        incroyable skin :tada:
                        Avec '.$winners[1]['weekly_likes'].' :sparkling_heart:
                        [Aller sur la page du skin]('.route('skins.show', $winners[1]['skin_id']).')',
                    'color' => 8041236,
                    'image' => [
                        'url' => asset('storage/'.$winners[1]['skin_image_path']),
                    ],
                    'thumbnail' => [
                        'url' => asset('storage/images/misc_ui/dofus_emeraude.png'),
                    ],
                ],
                [
                    'title' => '3ème place - Cawotte',
                    'description' => 'Bravo à ***'.$winners[2]['user_name'].'***, :medal: pour ce
                        magnifique skin :confetti_ball:
                        Avec '.$winners[2]['weekly_likes'].' :sparkling_heart:
                        [Aller sur la page du skin]('.route('skins.show', $winners[2]['skin_id']).')',
                    'color' => 14831887,
                    'image' => [
                        'url' => asset('storage/'.$winners[2]['skin_image_path']),
                    ],
                    'thumbnail' => [
                        'url' => asset('storage/images/misc_ui/dofus_cawotte.png'),
                    ],
                ],
                [
                    'title' => 'Top 10 :sparkles:',
                    'description' => 'Le concours est terminé ! Bien joué à tous les participants, voici le top 10 des meilleurs créateurs de skins de cette semaine !

                         **'.$topTen[0]['user_name'].'**
                         **'.$topTen[1]['user_name'].'**
                         **'.$topTen[2]['user_name'].'**
                         **'.$topTen[3]['user_name'].'**
                         **'.$topTen[4]['user_name'].'**
                         **'.$topTen[5]['user_name'].'**
                         **'.$topTen[6]['user_name'].'**
                         **'.$topTen[7]['user_name'].'**
                         **'.$topTen[8]['user_name'].'**
                         **'.$topTen[9]['user_name'].'**

                        *Continuez à partager vos skins sur [Barbofus]('.route('home').'), on les adore* :sparkling_heart:',
                    'color' => 16562499,
                ],
            ],
        ];

        Http::post($url, $body);
    }
}
