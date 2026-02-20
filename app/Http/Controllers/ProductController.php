<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Diccionario;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

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
        $statusOptions = $this->obtenerCatalogo('producto_estado', [
            ['numero' => 1, 'descripcion' => 'Activo', 'siglas' => 'ACT'],
            ['numero' => 2, 'descripcion' => 'Inactivo', 'siglas' => 'INA'],
            ['numero' => 3, 'descripcion' => 'Descontinuado', 'siglas' => 'DSC'],
        ]);
        $unitOptions = $this->obtenerCatalogo('producto_unidad', [
            ['numero' => 1, 'descripcion' => 'Unidad', 'siglas' => 'UNI'],
            ['numero' => 2, 'descripcion' => 'Litro', 'siglas' => 'LTR'],
            ['numero' => 3, 'descripcion' => 'Kilogramo', 'siglas' => 'KGM'],
            ['numero' => 4, 'descripcion' => 'Caja', 'siglas' => 'CAJ'],
            ['numero' => 5, 'descripcion' => 'Set', 'siglas' => 'SET'],
            ['numero' => 6, 'descripcion' => 'Paquete', 'siglas' => 'PAQ'],
        ]);

        return view('products.create', compact('categories', 'statusOptions', 'unitOptions'));
    }

    public function store(Request $request)
    {
        $statusSiglas = $this->obtenerSiglasCatalogo('producto_estado', ['ACT', 'INA', 'DSC']);
        $unitSiglas = $this->obtenerSiglasCatalogo('producto_unidad', ['UNI', 'LTR', 'KGM', 'CAJ', 'SET', 'PAQ']);

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'required|string|max:64|unique:products,barcode',
            'sku' => 'nullable|string|max:64',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'unit' => ['required', 'string', 'max:32', Rule::in($unitSiglas)],
            'status' => ['required', 'string', Rule::in($statusSiglas)],
        ]);

        Product::create($data);

        return redirect()
            ->route('admin.productos.index')
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
        $statusOptions = $this->obtenerCatalogo('producto_estado', [
            ['numero' => 1, 'descripcion' => 'Activo', 'siglas' => 'ACT'],
            ['numero' => 2, 'descripcion' => 'Inactivo', 'siglas' => 'INA'],
            ['numero' => 3, 'descripcion' => 'Descontinuado', 'siglas' => 'DSC'],
        ]);
        $unitOptions = $this->obtenerCatalogo('producto_unidad', [
            ['numero' => 1, 'descripcion' => 'Unidad', 'siglas' => 'UNI'],
            ['numero' => 2, 'descripcion' => 'Litro', 'siglas' => 'LTR'],
            ['numero' => 3, 'descripcion' => 'Kilogramo', 'siglas' => 'KGM'],
            ['numero' => 4, 'descripcion' => 'Caja', 'siglas' => 'CAJ'],
            ['numero' => 5, 'descripcion' => 'Set', 'siglas' => 'SET'],
            ['numero' => 6, 'descripcion' => 'Paquete', 'siglas' => 'PAQ'],
        ]);

        return view('products.edit', [
            'product' => $producto,
            'categories' => $categories,
            'statusOptions' => $statusOptions,
            'unitOptions' => $unitOptions,
        ]);
    }

    public function update(Request $request, Product $producto)
    {
        $statusSiglas = $this->obtenerSiglasCatalogo('producto_estado', ['ACT', 'INA', 'DSC']);
        $unitSiglas = $this->obtenerSiglasCatalogo('producto_unidad', ['UNI', 'LTR', 'KGM', 'CAJ', 'SET', 'PAQ']);

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'required|string|max:64|unique:products,barcode,' . $producto->id,
            'sku' => 'nullable|string|max:64',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'unit' => ['required', 'string', 'max:32', Rule::in($unitSiglas)],
            'status' => ['required', 'string', Rule::in($statusSiglas)],
        ]);

        $producto->update($data);

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $producto)
    {
        $producto->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    private function obtenerCatalogo(string $tipo, array $fallback): Collection
    {
        $catalogo = Diccionario::porTipo($tipo)->orderBy('orden')->get();

        if ($catalogo->isNotEmpty()) {
            return $catalogo->map(function ($item) {
                return (object) [
                    'numero' => (int) ($item->numero ?? $item->orden ?? 0),
                    'descripcion' => trim((string) ($item->descripcion ?? '')),
                    'siglas' => strtoupper(trim((string) ($item->siglas ?? $item->valor ?? ''))),
                ];
            })->filter(fn ($item) => $item->siglas !== '' && $item->descripcion !== '')->values();
        }

        return collect($fallback)->map(function ($item) {
            return (object) [
                'numero' => (int) ($item['numero'] ?? 0),
                'descripcion' => trim((string) ($item['descripcion'] ?? '')),
                'siglas' => strtoupper(trim((string) ($item['siglas'] ?? ''))),
            ];
        })->values();
    }

    private function obtenerSiglasCatalogo(string $tipo, array $fallback): array
    {
        $siglas = collect(Diccionario::siglas($tipo))
            ->map(fn ($sigla) => strtoupper(trim((string) $sigla)))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (!empty($siglas)) {
            return $siglas;
        }

        return collect($fallback)
            ->map(fn ($sigla) => strtoupper(trim((string) $sigla)))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
