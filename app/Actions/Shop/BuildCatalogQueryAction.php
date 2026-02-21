<?php

namespace App\Actions\Shop;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BuildCatalogQueryAction
{
    public function execute(Request $request): Builder
    {
        $query = Product::onlyActive()
            ->select(['id', 'name', 'price', 'image', 'category_id', 'created_at'])
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->with('category:id,name');

        if ($request->filled('category')) {
            $query->where('category_id', (int) $request->input('category'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        $sort = (string) $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderByDesc('created_at');
                break;
        }

        return $query;
    }
}
