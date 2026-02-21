<?php

namespace App\Http\Controllers\Shop;

use App\Actions\Shop\BuildCatalogQueryAction;
use App\Actions\Shop\BuildRelatedProductsQueryAction;
use App\Actions\Shop\BuildSearchProductsQueryAction;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct(
        private readonly BuildCatalogQueryAction $buildCatalogQueryAction,
        private readonly BuildSearchProductsQueryAction $buildSearchProductsQueryAction,
        private readonly BuildRelatedProductsQueryAction $buildRelatedProductsQueryAction,
    ) {
    }

    public function home()
    {
        $featuredProducts = Product::onlyActive()
            ->select(['id', 'name', 'price', 'image', 'category_id'])
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->with('category:id,name')
            ->inRandomOrder()
            ->limit(8)
            ->get();

        $categories = Category::query()
            ->select(['id', 'name'])
            ->withCount(['products' => function ($query) {
                $query->onlyActive();
            }])
            ->get();

        return view('shop.home', compact('featuredProducts', 'categories'));
    }

    public function catalog(Request $request)
    {
        $products = $this->buildCatalogQueryAction
            ->execute($request)
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        return view('shop.catalog', compact('products', 'categories'));
    }

    public function category(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->onlyActive()
            ->select(['id', 'name', 'price', 'image', 'category_id', 'created_at'])
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->with('category:id,name')
            ->paginate(12);

        return view('shop.category', compact('category', 'products'));
    }

    public function product(Product $product)
    {
        if ($product->status !== 'ACT') {
            abort(404);
        }

        $relatedProducts = $this->buildRelatedProductsQueryAction
            ->execute($product)
            ->limit(4)
            ->get();

        return view('shop.product', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $products = $this->buildSearchProductsQueryAction
            ->execute((string) $query)
            ->paginate(12)
            ->withQueryString();

        return view('shop.search', compact('products', 'query'));
    }
}
