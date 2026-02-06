<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Zone;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('zone')->orderByDesc('id')->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $zones = Zone::orderBy('name')->get();
        return view('categories.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:128',
            'code' => 'nullable|string|max:32',
            'description' => 'nullable|string',
        ]);

        Category::create($data);

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function show(Category $categoria)
    {
        return view('categories.show', ['category' => $categoria]);
    }

    public function edit(Category $categoria)
    {
        $zones = Zone::orderBy('name')->get();
        return view('categories.edit', ['category' => $categoria, 'zones' => $zones]);
    }

    public function update(Request $request, Category $categoria)
    {
        $data = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:128',
            'code' => 'nullable|string|max:32',
            'description' => 'nullable|string',
        ]);

        $categoria->update($data);

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $categoria)
    {
        if ($categoria->products()->exists()) {
            return redirect()->route('admin.categorias.index')->with('error', 'No se puede eliminar una categoría con productos asociados.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
