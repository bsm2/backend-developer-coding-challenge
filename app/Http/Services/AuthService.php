<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Summary of register
     * @param mixed $request
     * @return array{token: mixed, user: mixed}
     */
    public function register($request)
    {
        $validated = $request->safe()->only('name', 'email', 'password');
        $user = User::create($validated);
        $data = $this->createToken($user);

        return $data;
    }
    public function login($request)
    {
        $credentials = $request->safe()->only('email', 'password');
        $user = User::where('email', $credentials['email'])->firstOrFail();

        if (!Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $data = $this->createToken($user);

        return $data;
    }

    public function createToken($user)
    {
        $token = $user->createToken('auth_token')->plainTextToken;
        $data = ['token' => $token, 'user' => $user];

        return $data;
    }

    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
