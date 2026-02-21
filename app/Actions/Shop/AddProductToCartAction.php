<?php

namespace App\Actions\Shop;

use App\Models\Product;
use App\Services\CartService;

class AddProductToCartAction
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function execute(int $productId, float $quantity): AddProductToCartResult
    {
        $product = Product::findOrFail($productId);

        if ($product->status !== 'ACT') {
            return new AddProductToCartResult(
                AddProductToCartResult::PRODUCT_UNAVAILABLE,
                $product
            );
        }

        if ((float) $product->stock_quantity < $quantity) {
            return new AddProductToCartResult(
                AddProductToCartResult::INSUFFICIENT_STOCK,
                $product,
                (float) $product->stock_quantity
            );
        }

        $this->cartService->addItem($product, $quantity);

        return new AddProductToCartResult(
            AddProductToCartResult::SUCCESS,
            $product
        );
    }
}
