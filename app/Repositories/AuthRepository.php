<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function register($data)
    {
        $user = $this->queryInstance()->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['data' => ['user' => $user, 'access_token' => $token, 'token_type' => 'Bearer']]);
    }

    public function login($data)
    {
        if (!Auth::attempt($data)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['data' => ['user' => $user, 'access_token' => $token, 'token_type' => 'Bearer']]);
    }

    private function queryInstance()
    {
        return new User();
    }
}
