<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CachePublicPages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Ne pas toucher aux requêtes authentifiées ou Livewire
        if (
            auth()->check() ||
            $request->is('livewire/*') ||
            $request->ajax() ||
            $request->isMethod('POST')
        ) {
            return $response;
        }

        // Supprimer les headers bloquants de Laravel/PHP
        $response->headers->remove('Pragma');
        $response->headers->set('Cache-Control', 'public, s-maxage=300, max-age=0, must-revalidate');
        $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 300) . ' GMT');
        $response->headers->set('Surrogate-Control', 'max-age=300');

        return $response;
    }
}
