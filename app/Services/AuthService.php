<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $this->createToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        $token = $this->createToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout(PersonalAccessToken $token): bool
    {
        return $token->delete();
    }

    private function createToken(User $user): string
    {
        $expirationTime = now()->addMinutes(config('sanctum.expiration', 1440));

        return $user->createToken('auth_token', ['*'], $expirationTime)->plainTextToken;
    }
}
