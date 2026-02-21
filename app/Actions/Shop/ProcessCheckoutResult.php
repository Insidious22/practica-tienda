<?php

namespace App\Actions\Shop;

use App\Models\SalesOrder;

class ProcessCheckoutResult
{
    private function __construct(
        public readonly bool $ok,
        public readonly ?SalesOrder $order = null,
        public readonly ?string $error = null
    ) {
    }

    public static function success(SalesOrder $order): self
    {
        return new self(true, $order);
    }

    public static function paymentFailed(string $error): self
    {
        return new self(false, null, $error);
    }

    public static function failed(): self
    {
        return new self(false, null, null);
    }
}
