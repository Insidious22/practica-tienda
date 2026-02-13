<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function createOrder(Cart $cart, array $shippingData, User $user): SalesOrder
    {
        return DB::transaction(function () use ($cart, $shippingData, $user) {
            $totals = $this->calculateTotals($cart);

            $order = SalesOrder::create([
                'order_number' => SalesOrder::generateOrderNumber(),
                'user_id' => $user->id,
                'status' => 'pending',
                'channel' => 'online',
                'online_status' => 'pending',
                'shipping_address' => $shippingData['shipping_address'],
                'shipping_city' => $shippingData['shipping_city'],
                'shipping_postal_code' => $shippingData['shipping_postal_code'],
                'shipping_notes' => $shippingData['shipping_notes'] ?? null,
                'subtotal' => $totals['subtotal'],
                'tax_rate' => $totals['tax_rate'],
                'tax_total' => $totals['tax_total'],
                'total' => $totals['total'],
            ]);

            // Create order items
            foreach ($cart->items as $cartItem) {
                SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->unit_price,
                    'subtotal' => $cartItem->total,
                    'total' => $cartItem->total,
                    // Snapshot of product data
                    'product_name' => $cartItem->product->name,
                    'product_barcode' => $cartItem->product->barcode,
                    'unit' => $cartItem->product->unit ?? 'UNI',
                ]);
            }

            return $order;
        });
    }

    public function calculateTotals(Cart $cart): array
    {
        $subtotal = $cart->subtotal;
        $taxRate = 15; // IVA Ecuador 15%
        $taxTotal = $subtotal * ($taxRate / 100);
        $shipping = 0; // Free shipping

        return [
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_total' => round($taxTotal, 2),
            'shipping' => $shipping,
            'total' => round($subtotal + $taxTotal + $shipping, 2),
        ];
    }

    public function validateStock(Cart $cart): array
    {
        $errors = [];

        foreach ($cart->items as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                $errors[] = [
                    'product' => $item->product->name,
                    'requested' => $item->quantity,
                    'available' => $item->product->stock_quantity,
                ];
            }
        }

        return $errors;
    }

    public function reserveStock(SalesOrder $order): void
    {
        foreach ($order->items as $item) {
            $item->product->decrement('stock_quantity', $item->quantity);
        }
    }

    public function releaseStock(SalesOrder $order): void
    {
        foreach ($order->items as $item) {
            $item->product->increment('stock_quantity', $item->quantity);
        }
    }

    public function markAsPaid(SalesOrder $order): void
    {
        $order->update([
            'status' => 'completed',
            'online_status' => 'paid',
            'completed_at' => now(),
        ]);

        $this->reserveStock($order);
    }
}

