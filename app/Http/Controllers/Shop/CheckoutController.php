<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CheckoutService $checkoutService,
        protected PaymentService $paymentService
    ) {
    }

    public function index()
    {
        $cart = $this->cartService->getCart()->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('shop.cart')
                ->with('error', 'Tu carrito está vacío');
        }

        // Validate stock
        $stockErrors = $this->checkoutService->validateStock($cart);
        if (!empty($stockErrors)) {
            $errorMessages = collect($stockErrors)->map(function ($error) {
                return "{$error['product']}: solo hay {$error['available']} disponibles";
            })->join(', ');

            return redirect()->route('shop.cart')
                ->with('error', "Algunos productos no tienen stock suficiente: {$errorMessages}");
        }

        $totals = $this->checkoutService->calculateTotals($cart);
        $user = auth()->user();

        return view('shop.checkout.index', compact('cart', 'totals', 'user'));
    }

    public function saveShipping(Request $request)
    {
        $data = $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_notes' => 'nullable|string|max:500',
        ]);

        session(['checkout_shipping' => $data]);

        return redirect()->route('shop.checkout.payment');
    }

    public function payment()
    {
        if (!session('checkout_shipping')) {
            return redirect()->route('shop.checkout.index');
        }

        $cart = $this->cartService->getCart()->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('shop.cart');
        }

        $totals = $this->checkoutService->calculateTotals($cart);
        $shippingData = session('checkout_shipping');

        return view('shop.checkout.payment', compact('cart', 'totals', 'shippingData'));
    }

    public function process(Request $request)
    {
        $cart = $this->cartService->getCart()->load('items.product');
        $shippingData = session('checkout_shipping');

        if (!$shippingData || $cart->items->isEmpty()) {
            return redirect()->route('shop.checkout.index');
        }

        // Validate stock one more time
        $stockErrors = $this->checkoutService->validateStock($cart);
        if (!empty($stockErrors)) {
            return redirect()->route('shop.cart')
                ->with('error', 'Algunos productos ya no tienen stock suficiente');
        }

        try {
            // Create order
            $order = $this->checkoutService->createOrder(
                $cart,
                $shippingData,
                auth()->user()
            );

            // Process payment (simplified version)
            $paymentResult = $this->paymentService->processPayment($order);

            if ($paymentResult['success']) {
                // Mark as paid
                $this->checkoutService->markAsPaid($order);

                // Clear cart and session
                $this->cartService->clear();
                session()->forget('checkout_shipping');

                return redirect()->route('shop.checkout.confirmation', $order)
                    ->with('success', '¡Pedido realizado con éxito!');
            }

            // Payment failed - delete order
            $order->delete();

            return redirect()->route('shop.checkout.payment')
                ->with('error', 'Error al procesar el pago: ' . ($paymentResult['error'] ?? 'Error desconocido'));

        } catch (\Exception $e) {
            return redirect()->route('shop.checkout.payment')
                ->with('error', 'Error al procesar tu pedido. Por favor intenta nuevamente.');
        }
    }

    public function confirmation(SalesOrder $order)
    {
        // Verify order belongs to current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('shop.checkout.confirmation', compact('order'));
    }
}
