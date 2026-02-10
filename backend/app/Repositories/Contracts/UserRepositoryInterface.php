<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface {
    public function create(array $data): User;
    public function findByUsername(string $username): ?User;
    public function all(): Collection;
    public function update(User $user ,array $data): User;
}