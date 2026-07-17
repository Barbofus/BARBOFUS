<?php

namespace App\Enums;

enum WeaponSubcategorieEnum: string
{
    case ARC = 'arc';
    case BAGUETTE = 'baguette';
    case BATON = 'baton';
    case DAGUE = 'dague';
    case EPEE = 'epee';
    case MARTEAU = 'marteau';
    case PELLE = 'pelle';
    case HACHE = 'hache';
    case LANCE = 'lance';
    case ARME_MAGIQUE = 'arme_magique';
    case PIOCHE = 'pioche';
    case FAUX = 'faux';
    case OUTIL = 'outil';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(WeaponSubcategorieEnum::cases(), 'value');
    }
}
