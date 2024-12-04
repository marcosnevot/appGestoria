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

        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' https://maps.googleapis.com; style-src 'self' https://fonts.googleapis.com; img-src 'self' data: https://maps.googleapis.com;");

        return $response;
    }
}
