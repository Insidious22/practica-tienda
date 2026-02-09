<?php

namespace App\Services;

use App\Models\PaymentMethod;
use App\Models\SalesOrder;
use App\Models\SalesOrderPayment;
use App\Models\User;

class PaymentService
{
    
    public function processPayment(SalesOrder $order, string $paymentMethodCode = 'wallet'): array
    {
    
        $paymentMethod = PaymentMethod::where('code', $paymentMethodCode)->first();

        if (!$paymentMethod) {
            return [
                'success' => false,
                'error' => 'Método de pago no encontrado',
            ];
        }

        $payment = SalesOrderPayment::create([
            'sales_order_id' => $order->id,
            'payment_method_id' => $paymentMethod->id,
            'amount' => $order->total,
            'reference' => 'SIM-' . strtoupper(uniqid()),
            'notes' => 'Pago simulado - pendiente integración con pasarela',
        ]);

        return [
            'success' => true,
            'payment' => $payment,
            'message' => 'Pago procesado exitosamente',
        ];
    }

    public function createStripePaymentIntent(SalesOrder $order): array
    {
     
        return [
            'success' => true,
            'client_secret' => 'pi_simulated_' . uniqid(),
            'payment_intent_id' => 'pi_' . uniqid(),
        ];
    }

    public function handleStripeWebhook(array $payload): void
    {
        // Aquí se procesaría el webhook real de Stripe
    }
}
