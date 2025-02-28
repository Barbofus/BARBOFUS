<?php

declare(strict_types=1);

namespace App\Actions\Utils;

/**
 * Check if locale has been registered, or give their browser default
 */
final class GetCurrentLocale
{
    /**
     * Check if user is connected to take the locale in database, if not check the localStorage, else give their browser default
     */
    public function __invoke(): string
    {
        if (auth()->check()) {
            return auth()->user()->locale;
        } elseif (session()->has('locale')) {
            return session('locale');
        }

        return 'fr';
    }
}
