<?php

namespace App\Http\Controllers\Shop;

use App\Actions\Shop\AddProductToCartAction;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Services\CartService;
use App\Services\TurboFrameResponder;
use App\Services\TurboService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected AddProductToCartAction $addProductToCartAction,
        protected TurboFrameResponder $turboFrameResponder
    ) {
    }

    public function index(): View
    {
        $cart = $this->cartService->getCart()->load('items.product');

        return view('shop.cart', compact('cart'));
    }

    public function add(Request $request): Response|JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1'
        ]);

        $result = $this->addProductToCartAction->execute(
            (int) $data['product_id'],
            (float) $data['quantity']
        );

        if ($result->isUnavailable()) {
            // Support both Turbo and regular requests
            if (TurboService::isTurboRequest()) {
                return $this->turboFrameResponder->frame(
                    'shop.frames.cart-updated',
                    [
                        'type' => 'danger',
                        'message' => 'Producto no disponible',
                    ]
                );
            }
            return back()->with('error', 'Producto no disponible');
        }

        if ($result->isInsufficientStock()) {
            $msg = "Stock insuficiente. Solo hay {$result->availableStock} unidades disponibles.";
            if (TurboService::isTurboRequest()) {
                return $this->turboFrameResponder->frame(
                    'shop.frames.cart-updated',
                    [
                        'type' => 'warning',
                        'message' => $msg,
                    ]
                );
            }
            return back()->with('error', $msg);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart' => $this->cartService->getCart()->load('items.product'),
                'message' => 'Producto agregado al carrito'
            ]);
        }

        if (TurboService::isTurboRequest()) {
            return $this->turboFrameResponder->frame(
                'shop.frames.cart-updated',
                [
                    'type' => 'success',
                    'message' => "'{$result->product->name}' agregado al carrito",
                    'nextUrl' => route('content.cart'),
                ]
            );
        }

        return back()->with('success', 'Producto agregado al carrito');
    }

    public function update(Request $request, CartItem $item): Response|RedirectResponse
    {
        $request->validate(['quantity' => 'required|numeric|min:0']);

        $cart = $this->cartService->getCart();
        if ($item->cart_id !== $cart->id) {
            abort(403);
        }

        if ($request->quantity == 0) {
            $this->cartService->removeItem($item);
            if (TurboService::isTurboRequest()) {
                return $this->turboFrameResponder->redirect(route('content.cart'));
            }
            return back()->with('success', 'Producto eliminado del carrito');
        }

        if ($item->product->stock_quantity < $request->quantity) {
            if (TurboService::isTurboRequest()) {
                return $this->turboFrameResponder->frame(
                    'shop.frames.cart-updated',
                    [
                        'type' => 'warning',
                        'message' => 'Stock insuficiente. Solo hay ' . $item->product->stock_quantity . ' unidades disponibles.',
                        'nextUrl' => route('content.cart'),
                    ]
                );
            }
            return back()->with('error', 'Stock insuficiente. Solo hay ' . $item->product->stock_quantity . ' unidades disponibles.');
        }

        $this->cartService->updateQuantity($item, $request->quantity);

        if (TurboService::isTurboRequest()) {
            return $this->turboFrameResponder->redirect(route('content.cart'));
        }

        return back()->with('success', 'Carrito actualizado');
    }

    public function remove(CartItem $item): Response|RedirectResponse
    {
        $cart = $this->cartService->getCart();
        if ($item->cart_id !== $cart->id) {
            abort(403);
        }

        $this->cartService->removeItem($item);

        if (TurboService::isTurboRequest()) {
            return $this->turboFrameResponder->redirect(route('content.cart'));
        }

        return back()->with('success', 'Producto eliminado del carrito');
    }

    public function clear(): Response|RedirectResponse
    {
        $this->cartService->clear();

        if (TurboService::isTurboRequest()) {
            return $this->turboFrameResponder->redirect(route('content.cart'));
        }

        return back()->with('success', 'Carrito vaciado');
    }

    public function getCartData(): JsonResponse
    {
        $cart = $this->cartService->getCart()->load('items.product');

        return response()->json([
            'items' => $cart->items,
            'total' => $cart->subtotal,
            'count' => $cart->total_items
        ]);
    }
}
