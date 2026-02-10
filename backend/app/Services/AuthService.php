<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        private UserRepositoryInterface $userRepo
    ) {}

    public function register(array $data): array
    {
        if ($this->userRepo->findByUsername($data['username'])) {
            throw ValidationException::withMessages([
                'username' => ['Username already taken']
            ]);
        }

        $user = $this->userRepo->create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return compact('user', 'token');
    }

    public function login(string $username, string $password): array
    {
        $user = $this->userRepo->findByUsername($username);

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Invalid credentials']
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return compact('user', 'token');
    }
}