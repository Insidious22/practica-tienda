<?php

namespace App\Actions\Shop;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class BuildRelatedProductsQueryAction
{
    public function execute(Product $product): Builder
    {
        return Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->onlyActive()
            ->select(['id', 'name', 'price', 'image', 'category_id'])
            ->with('category:id,name');
    }
}
