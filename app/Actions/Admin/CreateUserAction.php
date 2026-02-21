<?php

namespace App\Actions\Admin;

use App\Models\User;

class CreateUserAction
{
    public function execute(array $data, int $assignedBy): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'] ?? null,
        ]);

        $user->roles()->attach($data['roles'], [
            'assigned_by' => $assignedBy,
            'assigned_at' => now(),
        ]);

        return $user;
    }
}
