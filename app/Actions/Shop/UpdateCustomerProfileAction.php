<?php

namespace App\Actions\Shop;

use App\Models\User;

class UpdateCustomerProfileAction
{
    public function execute(User $user, array $data): User
    {
        $user->update($data);

        return $user->fresh();
    }
}
