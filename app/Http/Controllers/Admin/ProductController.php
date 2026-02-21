<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\CatalogOptionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private readonly CatalogOptionService $catalogOptionService)
    {
    }

    public function getList(Request $request): View
    {
        $products = Product::with('category.zone')
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = $request->string('search')->toString();
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('barcode', 'like', "%{$term}%")
                    ->orWhere('sku', 'like', "%{$term}%");
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.frames.products-list', compact('products'));
    }

    public function getForm(?Product $product = null): View
    {
        $categories = Category::with('zone')->orderBy('name')->get();
        $statusOptions = $this->catalogOptionService->options('producto_estado', [
            ['numero' => 1, 'descripcion' => 'Activo', 'siglas' => 'ACT'],
            ['numero' => 2, 'descripcion' => 'Inactivo', 'siglas' => 'INA'],
            ['numero' => 3, 'descripcion' => 'Descontinuado', 'siglas' => 'DSC'],
        ]);
        $unitOptions = $this->catalogOptionService->options('producto_unidad', [
            ['numero' => 1, 'descripcion' => 'Unidad', 'siglas' => 'UNI'],
            ['numero' => 2, 'descripcion' => 'Litro', 'siglas' => 'LTR'],
            ['numero' => 3, 'descripcion' => 'Kilogramo', 'siglas' => 'KGM'],
            ['numero' => 4, 'descripcion' => 'Caja', 'siglas' => 'CAJ'],
            ['numero' => 5, 'descripcion' => 'Set', 'siglas' => 'SET'],
            ['numero' => 6, 'descripcion' => 'Paquete', 'siglas' => 'PAQ'],
        ]);

        return view('admin.frames.product-form', compact('product', 'categories', 'statusOptions', 'unitOptions'));
    }

    public function store(Request $request): Response
    {
        $data = $request->validate($this->rules());

        Product::create($data);

        return response()
            ->view('admin.frames.form-success', [
                'message' => 'Producto creado correctamente.',
                'redirectUrl' => route('admin.productos.index'),
            ])
            ->header('Turbo-Location', route('admin.productos.index'));
    }

    public function update(Request $request, Product $product): Response
    {
        $data = $request->validate($this->rules($product));

        $product->update($data);

        return response()
            ->view('admin.frames.form-success', [
                'message' => 'Producto actualizado correctamente.',
                'redirectUrl' => route('admin.productos.index'),
            ])
            ->header('Turbo-Location', route('admin.productos.index'));
    }

    public function destroy(Product $product): Response
    {
        $productName = $product->name;
        $product->delete();

        return response()
            ->view('admin.frames.form-success', [
                'message' => "Producto '{$productName}' eliminado.",
                'redirectUrl' => route('admin.products.list'),
            ]);
    }

    private function rules(?Product $product = null): array
    {
        $statusSiglas = $this->catalogOptionService->keys('producto_estado', ['ACT', 'INA', 'DSC']);
        $unitSiglas = $this->catalogOptionService->keys('producto_unidad', ['UNI', 'LTR', 'KGM', 'CAJ', 'SET', 'PAQ']);

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'barcode' => ['required', 'string', 'max:64', Rule::unique('products', 'barcode')->ignore($product?->id)],
            'sku' => ['nullable', 'string', 'max:64'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string', Rule::in($unitSiglas)],
            'status' => ['required', 'string', Rule::in($statusSiglas)],
        ];
    }
}
