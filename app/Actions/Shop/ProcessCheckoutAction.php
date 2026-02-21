<?php

namespace App\Actions\Shop;

use App\Models\Cart;
use App\Models\User;
use App\Services\CheckoutService;
use App\Services\PaymentService;
use Throwable;

class ProcessCheckoutAction
{
    public function __construct(
        private readonly CheckoutService $checkoutService,
        private readonly PaymentService $paymentService
    ) {
    }

    public function execute(Cart $cart, array $shippingData, User $user): ProcessCheckoutResult
    {
        try {
            $order = $this->checkoutService->createOrder($cart, $shippingData, $user);
            $paymentResult = $this->paymentService->processPayment($order);

            if (!($paymentResult['success'] ?? false)) {
                $order->delete();

                return ProcessCheckoutResult::paymentFailed(
                    (string) ($paymentResult['error'] ?? 'Error desconocido')
                );
            }

            $this->checkoutService->markAsPaid($order);

            return ProcessCheckoutResult::success($order);
        } catch (Throwable $exception) {
            return ProcessCheckoutResult::failed();
        }
    }
}
