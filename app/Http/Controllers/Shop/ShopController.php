<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('status', 'active')
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->with('category')
            ->inRandomOrder()
            ->limit(8)
            ->get();

        $categories = Category::withCount(['products' => function ($query) {
            $query->where('status', 'active');
        }])->get();

        return view('shop.home', compact('featuredProducts', 'categories'));
    }

    public function catalog(Request $request)
    {
        $query = Product::where('status', 'active')
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->with('category');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $sort = $request->get('sort', 'newest');
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
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('shop.catalog', compact('products', 'categories'));
    }

    public function category(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('status', 'active')
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->with('category')
            ->paginate(12);

        return view('shop.category', compact('category', 'products'));
    }

    public function product(Product $product)
    {
        if ($product->status !== 'active') {
            abort(404);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();

        return view('shop.product', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $products = Product::where('status', 'active')
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('barcode', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
            })
            ->with('category')
            ->paginate(12)
            ->withQueryString();

        return view('shop.search', compact('products', 'query'));
    }
}
