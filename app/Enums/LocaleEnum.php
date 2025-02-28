<?php

namespace App\Enums;

enum LocaleEnum: string
{
    case fr = 'fr';
    case en = 'en';
    case es = 'es';
    case pt = 'pt';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(LocaleEnum::cases(), 'value');
    }
}
