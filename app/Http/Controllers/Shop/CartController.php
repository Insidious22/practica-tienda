<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function index()
    {
        $cart = $this->cartService->getCart()->load('items.product');

        return view('shop.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->status !== 'active') {
            return back()->with('error', 'Producto no disponible');
        }

        if ($product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Stock insuficiente. Solo hay ' . $product->stock_quantity . ' unidades disponibles.');
        }

        $this->cartService->addItem($product, $request->quantity);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart' => $this->cartService->getCart()->load('items.product'),
                'message' => 'Producto agregado al carrito'
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate(['quantity' => 'required|numeric|min:0']);

        // Verify the item belongs to the current cart
        $cart = $this->cartService->getCart();
        if ($item->cart_id !== $cart->id) {
            abort(403);
        }

        if ($request->quantity == 0) {
            $this->cartService->removeItem($item);
            return back()->with('success', 'Producto eliminado del carrito');
        }

        // Check stock
        if ($item->product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Stock insuficiente. Solo hay ' . $item->product->stock_quantity . ' unidades disponibles.');
        }

        $this->cartService->updateQuantity($item, $request->quantity);

        return back()->with('success', 'Carrito actualizado');
    }

    public function remove(CartItem $item)
    {
        // Verify the item belongs to the current cart
        $cart = $this->cartService->getCart();
        if ($item->cart_id !== $cart->id) {
            abort(403);
        }

        $this->cartService->removeItem($item);

        return back()->with('success', 'Producto eliminado del carrito');
    }

    public function clear()
    {
        $this->cartService->clear();

        return back()->with('success', 'Carrito vaciado');
    }

    public function getCartData()
    {
        $cart = $this->cartService->getCart()->load('items.product');

        return response()->json([
            'items' => $cart->items,
            'total' => $cart->subtotal,
            'count' => $cart->total_items
        ]);
    }
}
