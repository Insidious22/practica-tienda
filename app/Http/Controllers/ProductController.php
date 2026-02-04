<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category.zone')->orderByDesc('id')->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::with('zone')->orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'required|string|max:64|unique:products,barcode',
            'sku' => 'nullable|string|max:64',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:32',
            'status' => 'required|in:active,inactive,discontinued',
        ]);

        Product::create($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(Product $producto)
    {
        return view('products.show', [
            'product' => $producto->load('category.zone'),
        ]);
    }

    public function edit(Product $producto)
    {
        $categories = Category::with('zone')->orderBy('name')->get();
        return view('products.edit', [
            'product' => $producto,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $producto)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'required|string|max:64|unique:products,barcode,' . $producto->id,
            'sku' => 'nullable|string|max:64',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:32',
            'status' => 'required|in:active,inactive,discontinued',
        ]);

        $producto->update($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $producto)
    {
        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
