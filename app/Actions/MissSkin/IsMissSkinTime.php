<?php

declare(strict_types=1);

namespace App\Actions\MissSkin;

final class IsMissSkinTime
{
    /**
     * @return bool
     * Vérifie si l'heure française permet d'attribuer le statut MissSkin (7h00 - 11h30)
     */
    public function __invoke(): bool
    {
        $frenchTime = now('Europe/Paris');
        $hour = $frenchTime->hour;
        $minute = $frenchTime->minute;
        $dayOfWeek = $frenchTime->dayOfWeek; // 2 = mardi

        // Seulement le mardi et entre 7h00 et 11h30
        return $dayOfWeek === 2 && (($hour >= 7 && $hour < 11) || ($hour === 11 && $minute <= 30));
    }
}
