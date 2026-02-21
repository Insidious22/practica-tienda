<?php

namespace App\Actions\Shop;

use App\Models\SalesOrder;

class GetCustomerOrderDetailAction
{
    public function execute(SalesOrder $order, int $userId): ?SalesOrder
    {
        if ($order->user_id !== $userId) {
            return null;
        }

        return $order->load(['items.product', 'payments']);
    }
}
