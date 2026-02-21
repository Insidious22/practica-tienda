<?php

namespace App\Actions\Shop;

use App\Models\Product;

class AddProductToCartResult
{
    public const SUCCESS = 'success';
    public const PRODUCT_UNAVAILABLE = 'product_unavailable';
    public const INSUFFICIENT_STOCK = 'insufficient_stock';

    public function __construct(
        public readonly string $status,
        public readonly Product $product,
        public readonly ?float $availableStock = null,
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->status === self::SUCCESS;
    }

    public function isUnavailable(): bool
    {
        return $this->status === self::PRODUCT_UNAVAILABLE;
    }

    public function isInsufficientStock(): bool
    {
        return $this->status === self::INSUFFICIENT_STOCK;
    }
}
