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

        // Uniquement GET, sans utilisateur connecté
        if ($request->isMethod('GET') && !auth()->check()) {
            $response->headers->set('Cache-Control', 'public, max-age=300, s-maxage=300');
            $response->headers->remove('Pragma');
        }

        return $response;
    }
}
