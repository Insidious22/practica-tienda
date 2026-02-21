<?php

namespace App\Actions\Admin;

use App\Models\User;

class UpdateUserAction
{
    public function execute(User $user, array $data, int $assignedBy): User
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ]);

        $syncData = collect($data['roles'])->mapWithKeys(fn ($roleId) => [
            $roleId => [
                'assigned_by' => $assignedBy,
                'assigned_at' => now(),
            ],
        ])->toArray();

        $user->roles()->sync($syncData);

        return $user->fresh('roles');
    }
}
