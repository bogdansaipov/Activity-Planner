<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface {

 public function create(array $data): User {
    return User::create($data);
 }

 public function findByUsername(string $username): ?User
 {
    return User::where('username', $username)->first();
 }

 public function all(): Collection
 {
    return User::all();
 }

 public function update(User $user ,array $data): User
 {
    $user->update($data);

    return $user->fresh();
 }
}