<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Routes sans formulaire POST — le CSRF n'est pas nécessaire
        '/',
        '/mentions-legales',
        '/socials',
        '/planning',
        '/recompenses',
        '/havre-sacs',
        '/outils',
        '/skins',
        '/unity-skins',
        // Les routes API Laravel dans web.php
        '/api/whoami',
        '/api/locale',
    ];
}
