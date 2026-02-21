<?php

namespace App\Actions\Admin;

use App\Models\User;
use DomainException;

class DeleteUserAction
{
    public function execute(User $targetUser, User $actor): void
    {
        if ($targetUser->id === $actor->id) {
            throw new DomainException('No puedes eliminar tu propia cuenta.');
        }

        if ($targetUser->salesOrders()->exists() || $targetUser->purchaseOrders()->exists()) {
            throw new DomainException('No puedes eliminar este usuario porque tiene órdenes asociadas.');
        }

        $targetUser->delete();
    }
}
