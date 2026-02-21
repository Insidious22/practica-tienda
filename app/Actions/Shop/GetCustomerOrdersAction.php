<?php

namespace App\Actions\Shop;

use App\Models\SalesOrder;

class GetCustomerOrdersAction
{
    public function execute(int $userId, int $perPage = 10)
    {
        return SalesOrder::where('user_id', $userId)
            ->where('channel', 'online')
            ->with('items')
            ->latest()
            ->paginate($perPage);
    }
}
