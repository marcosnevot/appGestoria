<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Configuración de CSP en una sola línea
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; " .
                "script-src 'self' https://maps.googleapis.com https://ajax.googleapis.com https://cdn.jsdelivr.net https://www.google.com https://www.gstatic.com 'unsafe-inline'; " .
                "style-src 'self' https://fonts.googleapis.com https://fonts.bunny.net 'unsafe-inline'; " .
                "img-src 'self' data: https://maps.googleapis.com; " .
                "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net; " .
                "frame-src 'self' https://www.google.com;"
        );


        return $response;
    }
}
