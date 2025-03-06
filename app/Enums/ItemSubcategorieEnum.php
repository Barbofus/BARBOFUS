<?php

namespace App\Enums;

enum ItemSubcategorieEnum: string
{
    case CEREMONIAL = 'ceremonial';
    case LIVINGOBJECT = 'livingObject';
    case MIMISYMBIC = 'mimisymbic';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(ItemSubcategorieEnum::cases(), 'value');
    }
}
