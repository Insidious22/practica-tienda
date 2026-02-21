<?php

namespace App\Actions\Shop;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class BuildSearchProductsQueryAction
{
    public function execute(string $term): Builder
    {
        return Product::onlyActive()
            ->select(['id', 'name', 'price', 'image', 'category_id', 'description'])
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%")
                    ->orWhere('barcode', 'like', "%{$term}%")
                    ->orWhere('sku', 'like', "%{$term}%");
            })
            ->with('category:id,name');
    }
}
