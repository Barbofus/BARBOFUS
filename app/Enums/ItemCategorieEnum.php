<?php

namespace App\Enums;

enum ItemCategorieEnum: string
{
    case HAT = 'hat';
    case CAPE = 'cape';
    case SHIELD = 'shield';
    case PET = 'pet';
    case WINGS = 'wings';
    case SHOULDERPADS = 'shoulderpads';
    case COSTUME = 'costume';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(ItemCategorieEnum::cases(), 'value');
    }
}
