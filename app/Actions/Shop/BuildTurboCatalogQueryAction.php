<?php

namespace App\Actions\Shop;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BuildTurboCatalogQueryAction
{
    public function execute(Request $request): Builder
    {
        $query = Product::query()
            ->onlyActive()
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->with(['category' => function ($q) {
                $q->select('id', 'name', 'slug');
            }]);

        if ($request->filled('search')) {
            $term = $request->string('search')->toString();
            $query->where(function ($builder) use ($term) {
                $builder->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->integer('category'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        return $query;
    }
}
