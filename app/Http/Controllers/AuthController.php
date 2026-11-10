<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciais inválidas',
            ], 401);
        }

        $ttl = (int) config('jwt.ttl', 60);

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl * 60,
        ]);
    }

    public function webLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'E-mail ou senha inválidos.',
                ])
                ->onlyInput('email');
        }

        $ttl = (int) config('jwt.ttl', 60);

        return redirect()
            ->route('countries.index')
            ->withCookie(cookie(
                'jwt_token',
                $token,
                $ttl,
                '/',
                null,
                false,
                true,
                false,
                'lax'
            ));
    }

    public function me()
    {
        return response()->json(
            Auth::guard('api')->user()
        );
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'message' => 'Logout realizado',
        ]);
    }

    public function webLogout(Request $request)
    {
        $token = $request->cookie('jwt_token');

        if ($token && !$request->bearerToken()) {
            $request->headers->set(
                'Authorization',
                'Bearer ' . $token
            );
        }

        try {
            Auth::guard('api')->logout();
        } catch (Throwable) {
        }

        return redirect()
            ->route('login')
            ->withCookie(cookie()->forget('jwt_token'));
    }
}