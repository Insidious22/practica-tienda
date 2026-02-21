<?php

namespace Tests\Unit\Shop;

use App\Actions\Shop\ProcessCheckoutResult;
use App\Models\SalesOrder;
use Tests\TestCase;

class ProcessCheckoutResultTest extends TestCase
{
    public function test_success_result_contains_order(): void
    {
        $order = new SalesOrder();
        $order->id = 99;

        $result = ProcessCheckoutResult::success($order);

        $this->assertTrue($result->ok);
        $this->assertSame($order, $result->order);
        $this->assertNull($result->error);
    }

    public function test_payment_failed_result_contains_error_message(): void
    {
        $result = ProcessCheckoutResult::paymentFailed('Pago rechazado');

        $this->assertFalse($result->ok);
        $this->assertNull($result->order);
        $this->assertSame('Pago rechazado', $result->error);
    }

    public function test_failed_result_has_no_order_or_error_message(): void
    {
        $result = ProcessCheckoutResult::failed();

        $this->assertFalse($result->ok);
        $this->assertNull($result->order);
        $this->assertNull($result->error);
    }
}
