<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // 🔒 Configuración base para producción
        $cspDirectives = [
            "default-src" => ["'self'"],
            "script-src" => ["'self'", "https://maps.googleapis.com", "https://ajax.googleapis.com", "https://cdn.jsdelivr.net", "https://www.google.com", "https://www.gstatic.com"],
            "style-src" => ["'self'", "https://fonts.googleapis.com", "https://fonts.bunny.net", "https://cdnjs.cloudflare.com"],
            "img-src" => ["'self'", "data:", "https://maps.googleapis.com", "https://lh3.googleusercontent.com"],
            "font-src" => ["'self'", "https://fonts.gstatic.com", "https://fonts.bunny.net", "https://cdnjs.cloudflare.com"],
            "frame-src" => ["'self'", "https://www.google.com"],
            "connect-src" => ["'self'"]
        ];

        // 🔥 En desarrollo, permitimos Vite sin duplicar reglas
        if (app()->environment('local')) {
            $cspDirectives["script-src"] = array_merge($cspDirectives["script-src"], ["'unsafe-inline'", "'unsafe-eval'", "http://localhost:5173", "ws://localhost:5173"]);
            $cspDirectives["style-src"] = array_merge($cspDirectives["style-src"], ["'unsafe-inline'", "http://localhost:5173"]);
            $cspDirectives["connect-src"] = array_merge($cspDirectives["connect-src"], ["http://localhost:5173", "ws://localhost:5173"]);
            $cspDirectives["img-src"] = array_merge($cspDirectives["img-src"], ["http://localhost:5173"]); // 🔥 Agrega localhost:5173 a img-src
        }


        // Convertir el array a un string formateado sin duplicados
        $cspHeader = [];
        foreach ($cspDirectives as $key => $values) {
            $cspHeader[] = $key . " " . implode(" ", array_unique($values));
        }

        // Aplicar la CSP correctamente
        $response->headers->set('Content-Security-Policy', implode("; ", $cspHeader));

        return $response;
    }
}
