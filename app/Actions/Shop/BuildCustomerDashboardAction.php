<?php

namespace App\Actions\Shop;

use App\Models\SalesOrder;
use App\Models\User;

class BuildCustomerDashboardAction
{
    public function execute(User $user): array
    {
        $recentOrders = SalesOrder::where('user_id', $user->id)
            ->where('channel', 'online')
            ->latest()
            ->limit(5)
            ->get();

        $totalOrders = SalesOrder::where('user_id', $user->id)
            ->where('channel', 'online')
            ->count();

        $totalSpent = SalesOrder::where('user_id', $user->id)
            ->where('channel', 'online')
            ->where('status', 'completed')
            ->sum('total');

        return [
            'recentOrders' => $recentOrders,
            'totalOrders' => $totalOrders,
            'totalSpent' => $totalSpent,
        ];
    }
}
