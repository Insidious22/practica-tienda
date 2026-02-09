<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected ?Cart $cart = null;

    public function getCart(): Cart
    {
        if ($this->cart) {
            return $this->cart;
        }

        $user = Auth::user();
        $sessionId = session()->getId();

        $this->cart = Cart::getOrCreate($user, $sessionId);

        return $this->cart;
    }

    public function addItem(Product $product, float $quantity = 1): CartItem
    {
        $cart = $this->getCart();

        $existingItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity,
            ]);
            return $existingItem->fresh();
        }

        return $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $product->price,
        ]);
    }

    public function updateQuantity(CartItem $item, float $quantity): CartItem
    {
        $item->update(['quantity' => $quantity]);
        return $item->fresh();
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function clear(): void
    {
        $cart = $this->getCart();
        $cart->items()->delete();
    }

    public function mergeGuestCartToUser(User $user, ?string $guestSessionId = null): void
    {
        $sessionId = $guestSessionId ?? session()->getId();

        $userCart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['session_id' => null]
        );

        $userCart->mergeGuestCart($sessionId);

        $this->cart = $userCart;
    }

    public function getTotal(): float
    {
        return $this->getCart()->subtotal;
    }

    public function getItemCount(): int
    {
        return $this->getCart()->total_items;
    }

    public function isEmpty(): bool
    {
        return $this->getCart()->items->isEmpty();
    }
}
