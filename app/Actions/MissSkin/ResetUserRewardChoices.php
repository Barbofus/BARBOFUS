<?php

declare(strict_types=1);

namespace App\Actions\MissSkin;

use App\Models\User;

final class ResetUserRewardChoices
{
    /**
     * Remet à zéro tous les choix de récompenses des utilisateurs
     * Utilisé automatiquement chaque mardi à 7h pour le nouveau concours Miss Skin
     */
    public function __invoke(): int
    {
        $affectedRows = User::whereNotNull('selected_reward_image')
            ->update(['selected_reward_image' => null]);

        \Log::info('Miss Skin reward choices reset', [
            'affected_users' => $affectedRows,
            'reset_time' => now()->toDateTimeString()
        ]);

        return $affectedRows;
    }
}
