<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

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

        return view('shop.account.index', compact('user', 'recentOrders', 'totalOrders', 'totalSpent'));
    }

    public function orders()
    {
        $orders = SalesOrder::where('user_id', Auth::id())
            ->where('channel', 'online')
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('shop.account.orders', compact('orders'));
    }

    public function orderDetail(SalesOrder $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'payments']);

        return view('shop.account.order-detail', compact('order'));
    }

    public function profile()
    {
        return view('shop.account.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }
        /** @var User $user */

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'document_type' => 'nullable|in:CEDULA,RUC,PASAPORTE',
            'document_number' => 'nullable|string|max:20',
        ]);

        $user->update($data);

        return back()->with('success', 'Perfil actualizado correctamente');
    }
}
