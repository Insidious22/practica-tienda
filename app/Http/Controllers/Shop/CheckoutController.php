<?php

namespace App\Http\Controllers\Shop;

use App\Actions\Shop\FormatStockErrorsAction;
use App\Actions\Shop\ProcessCheckoutAction;
use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use App\Models\User;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CheckoutService $checkoutService,
        protected FormatStockErrorsAction $formatStockErrorsAction,
        protected ProcessCheckoutAction $processCheckoutAction
    ) {
    }

    public function index(): View|RedirectResponse
    {
        $cart = $this->cartService->getCart()->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('shop.cart')
                ->with('error', 'Tu carrito esta vacio');
        }

        $stockErrors = $this->checkoutService->validateStock($cart);
        if (!empty($stockErrors)) {
            $errorMessages = $this->formatStockErrorsAction->execute($stockErrors);

            return redirect()->route('shop.cart')
                ->with('error', "Algunos productos no tienen stock suficiente: {$errorMessages}");
        }

        $totals = $this->checkoutService->calculateTotals($cart);
        $user = Auth::user();

        return view('shop.checkout.index', compact('cart', 'totals', 'user'));
    }

    public function saveShipping(Request $request): RedirectResponse
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

    public function payment(): View|RedirectResponse
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

    public function process(Request $request): RedirectResponse
    {
        $cart = $this->cartService->getCart()->load('items.product');
        $shippingData = session('checkout_shipping');
        $user = Auth::user();

        if (!$shippingData || $cart->items->isEmpty() || !$user instanceof User) {
            return redirect()->route('shop.checkout.index');
        }

        $stockErrors = $this->checkoutService->validateStock($cart);
        if (!empty($stockErrors)) {
            return redirect()->route('shop.cart')
                ->with('error', 'Algunos productos ya no tienen stock suficiente');
        }

        $result = $this->processCheckoutAction->execute($cart, $shippingData, $user);

        if ($result->ok && $result->order) {
            $this->cartService->clear();
            session()->forget('checkout_shipping');

            return redirect()->route('shop.checkout.confirmation', $result->order)
                ->with('success', 'Pedido realizado con exito');
        }

        if ($result->error) {
            return redirect()->route('shop.checkout.payment')
                ->with('error', 'Error al procesar el pago: ' . $result->error);
        }

        return redirect()->route('shop.checkout.payment')
            ->with('error', 'Error al procesar tu pedido. Por favor intenta nuevamente.');
    }

    public function confirmation(SalesOrder $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('shop.checkout.confirmation', compact('order'));
    }
}
