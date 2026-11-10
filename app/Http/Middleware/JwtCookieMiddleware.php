<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class JwtCookieMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt_token');

        if ($token && !$request->bearerToken()) {
            $request->headers->set(
                'Authorization',
                'Bearer ' . $token
            );
        }

        try {
            if (!Auth::guard('api')->check()) {
                return redirect()
                    ->route('login')
                    ->withErrors([
                        'auth' => 'Faça login para acessar o sistema.',
                    ]);
            }
        } catch (Throwable) {
            return redirect()
                ->route('login')
                ->withCookie(cookie()->forget('jwt_token'))
                ->withErrors([
                    'auth' => 'O token expirou ou foi invalidado.',
                ]);
        }

        return $next($request);
    }
}