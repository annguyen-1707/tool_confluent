<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Parse token và set user cho Auth
            $user = JWTAuth::parseToken()->authenticate();
            Log::info('JWT Authenticated', ['userId' => $user->id, 'username' => $user->username]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorized - Invalid or missing token'], 401);
        }

        return $next($request);
    }
}
