<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Zone;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalZones = Zone::count();
        $lowStockProducts = Product::where('stock_quantity', '<', 5)->count();
        $recentProducts = Product::with('category.zone')->orderByDesc('id')->limit(5)->get();
        $categories = Category::with('zone')->withCount('products')->orderBy('name')->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalZones',
            'lowStockProducts',
            'recentProducts',
            'categories'
        ));
    }
}
