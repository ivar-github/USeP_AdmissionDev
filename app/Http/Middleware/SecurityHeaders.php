<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        //RELAXED CSP
        // $response->headers->set('Content-Security-Policy',
        //     "default-src * data: blob: 'unsafe-inline' 'unsafe-eval';"
        // );

        $response->headers->set('Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://code.jquery.com http://code.jquery.com https://cdnjs.cloudflare.com http://cdnjs.cloudflare.com https://cdn.jsdelivr.net http://cdn.jsdelivr.net http://cdn.datatables.net https://cdn.datatables.net https://cdn.jsdelivr.net/npm/apexcharts; style-src 'self' 'unsafe-inline' https://fonts.bunny.net http://fonts.bunny.net http://cdn.datatables.net https://cdn.datatables.net https://cdnjs.cloudflare.com http://cdnjs.cloudflare.com; font-src 'self' https://fonts.bunny.net http://fonts.bunny.net; connect-src 'self' https://cdn.jsdelivr.net http://cdn.jsdelivr.net; img-src 'self' data:; child-src 'none'; frame-src 'none'; form-action 'self'; upgrade-insecure-requests;"
        );

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'no-referrer');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=()');
        $response->headers->set('Expect-CT', 'max-age=86400, enforce');

        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, proxy-revalidate');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        // $response->headers->set('Cross-Origin-Embedder-Policy', 'require-corp');


        //USE TO CLEARS DATA GLOBALLY
        // $response->headers->set('Clear-Site-Data', '"cookies", "storage", "executionContexts"');

        return $response;
    }
}
