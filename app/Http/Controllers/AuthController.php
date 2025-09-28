<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Tìm user trong DB
        $user = \App\Models\User::where('username', $credentials['username'])->first();

        if (! $user) {
            Log::warning('Login failed: User not found', ['username' => $credentials['username']]);
            return response()->json(['error' => 'Unauthorized - user not found'], 401);
        }

        // Kiểm tra password hash
        if (! Hash::check($credentials['password'], $user->password)) {
            Log::warning('Login failed: Wrong password', [
                'username' => $credentials['username'],
                'input_password' => $credentials['password']
            ]);
            return response()->json(['error' => 'Unauthorized - wrong password'], 401);
        }

        if (! $token = auth()->attempt($credentials)) {
            Log::error('Login failed: Auth::attempt() returned false', $credentials);
            return response()->json(['error' => 'Unauthorized - auth failed'], 401);
        }

        Log::info('Login success', ['username' => $credentials['username']]);
        return $this->respondWithToken($token);
    }
    public function me()
    {
        return response()->json(Auth::user());
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        Log::alert('Login success', [
            'userId' => Auth::id(),
            'username' => Auth::user()->username ?? null
        ]);

        return response()->json([
            'access_token' => $token,
            'expires_in'   => Auth::factory()->getTTL() * 60,
            'userId' => Auth::id(),
            'username' => Auth::user()->username ?? null,
            'role' => Auth::user()->role ?? null
        ]);
    }


    
}