<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySessionContext
{

    public function handle(Request $request, Closure $next)
    {
        $userAgent = $request->header('User-Agent');
        $ip = $request->ip();


        if (!session()->has('user_agent')) {
            session(['user_agent' => $userAgent]);
            session(['ip_address' => $ip]);
        }

        if (
            session('user_agent') !== $userAgent ||
            session('ip_address') !== $ip
        ) {
            // return response()->json(['error' => 'Session validation failed.'], 403);
            abort(403);
        }

        return $next($request);
    }
}
