<?php

declare(strict_types=1);

namespace App\Actions\MissSkin;

use App\Models\User;
use Illuminate\Support\Facades\File;

final class ResetUserRewardChoices
{
    /**
     * Remet à zéro tous les choix de récompenses des utilisateurs
     * ET réinitialise l'état du concours Miss Skin finalisé
     * Utilisé automatiquement chaque mardi à 7h pour le nouveau concours Miss Skin
     */
    public function __invoke(): int
    {
        $affectedRows = User::whereNotNull('selected_reward_image')
            ->update(['selected_reward_image' => null]);

        // Réinitialiser aussi l'état du concours Miss Skin finalisé
        $this->resetMissSkinContestState();

        \Log::info('Miss Skin reward choices and contest state reset', [
            'affected_users' => $affectedRows,
            'reset_time' => now()->toDateTimeString()
        ]);

        return $affectedRows;
    }

    /**
     * Réinitialise l'état du concours Miss Skin finalisé
     * en remettant les données du JSON à un état initial
     */
    private function resetMissSkinContestState(): void
    {
        $missSkinPath = storage_path('app/json/missskin.json');

        // S'assurer que le fichier existe
        if (!\File::exists($missSkinPath)) {
            \File::put($missSkinPath, json_encode(['theme' => 'A définir'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }

        // Réinitialiser les données du concours
        $missSkinData = [
            'theme' => 'A définir',
            'contest_finalized' => false,
            'finalized_winners' => [],
            'reset_time' => now()->toISOString()
        ];

        \File::put($missSkinPath, json_encode($missSkinData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
