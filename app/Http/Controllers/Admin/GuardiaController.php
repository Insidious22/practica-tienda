<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\GuardiaYaExisteException;
use App\Http\Controllers\Controller;
use App\Models\Guardia;
use App\Models\InventarioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuardiaController extends Controller
{
    public function index()
    {
        $guardias = Guardia::where('activo', true)->orderBy('id', 'desc')->get();
        return view('admin.guardias.index', compact('guardias'));
    }

    public function create()
    {
        $inventarioItems = InventarioItem::where('cantidad', '>', 0)->orderBy('nombre')->get();
        return view('admin.guardias.create', compact('inventarioItems'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'tipo_documento' => 'required|string|max:20',
            'turno' => 'required|string|max:20',
            'items' => 'required|array|min:1',
        ];

        if ($request->tipo_documento === 'cedula') {
            $rules['cedula'] = 'required|numeric|max_digits:10|min_digits:8';
        } else {
            $rules['cedula'] = 'required|alpha_num|max:30';
        }

        $request->validate($rules);

        $guardiaExistente = Guardia::where('cedula', $request->cedula)->first();

        if ($guardiaExistente) {
            if ($guardiaExistente->activo) {
                throw new GuardiaYaExisteException($request->cedula);
            }

            return redirect()->back()
                ->withInput()
                ->with('reactivar_id', $guardiaExistente->id)
                ->with('warning', 'El guardia con cedula ' . $request->cedula . ' esta INACTIVO. Deseas reactivarlo?');
        }

        $codigoGenerado = 'G-' . strtoupper(substr(uniqid(), -5));

        DB::transaction(function () use ($request, $codigoGenerado) {
            $guardia = Guardia::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'cedula' => $request->cedula,
                'tipo_documento' => $request->tipo_documento,
                'turno' => $request->turno,
                'codigo_unico' => $codigoGenerado,
                'activo' => true,
            ]);

            foreach ($request->items as $inventarioItemId) {
                if (!empty($inventarioItemId)) {
                    $inventarioItem = InventarioItem::find($inventarioItemId);
                    if ($inventarioItem && $inventarioItem->cantidad > 0) {
                        $guardia->items()->create([
                            'inventario_item_id' => $inventarioItemId,
                            'nombre_item' => $inventarioItem->nombre,
                            'codigo_serie' => $inventarioItem->codigo_serie,
                        ]);
                        $inventarioItem->decrement('cantidad');
                    }
                }
            }
        });

        return redirect()->route('admin.guardias.create')->with('success', 'Guardia guardado con codigo: ' . $codigoGenerado);
    }

    public function show(string $id)
    {
        $guardia = Guardia::with('items.inventarioItem')->findOrFail($id);
        $inventarioItems = InventarioItem::where('cantidad', '>', 0)->orderBy('nombre')->get();
        return view('admin.guardias.show', compact('guardia', 'inventarioItems'));
    }

    public function edit(string $id)
    {
        $guardia = Guardia::findOrFail($id);
        return view('admin.guardias.edit', compact('guardia'));
    }

    public function update(Request $request, string $id)
    {
        $guardia = Guardia::findOrFail($id);
        $guardia->update($request->only(['nombre', 'apellido', 'cedula', 'tipo_documento', 'turno']));

        return redirect()->route('admin.guardias.index')->with('success', 'Datos actualizados con exito.');
    }

    public function destroy(string $id)
    {
        $guardia = Guardia::with('items.inventarioItem')->findOrFail($id);

        DB::transaction(function () use ($guardia) {
            $guardia->activo = false;
            $guardia->save();

            foreach ($guardia->items as $item) {
                if ($item->inventarioItem) {
                    $item->inventarioItem->increment('cantidad');
                }
                $item->delete();
            }
        });

        return redirect()->route('admin.guardias.index')->with('success', 'Guardia marcado como INACTIVO y equipo devuelto.');
    }

    public function addItem(Request $request, string $id)
    {
        $guardia = Guardia::findOrFail($id);
        $request->validate([
            'inventario_item_id' => 'required|integer|exists:inventario_items,id',
        ]);

        $inventarioItemId = $request->input('inventario_item_id');
        $inventarioItem = InventarioItem::findOrFail($inventarioItemId);

        if ($inventarioItem->cantidad <= 0) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Item no disponible'], 400);
            }
            return redirect()->route('admin.guardias.show', $guardia->id)->with('error', 'Item no disponible');
        }

        $existingItem = $guardia->items()
            ->where('inventario_item_id', $inventarioItemId)
            ->exists();

        if ($existingItem) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Este item ya esta asignado al guardia'], 400);
            }
            return redirect()->route('admin.guardias.show', $guardia->id)->with('error', 'Este item ya esta asignado al guardia');
        }

        DB::transaction(function () use ($guardia, $inventarioItem) {
            $guardia->items()->create([
                'inventario_item_id' => $inventarioItem->id,
                'nombre_item' => $inventarioItem->nombre,
                'codigo_serie' => $inventarioItem->codigo_serie,
            ]);
            $inventarioItem->decrement('cantidad');
        });

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Item agregado correctamente']);
        }

        return redirect()->route('admin.guardias.show', $guardia->id)->with('success', 'Item agregado correctamente.');
    }

    public function reactivar(Request $request, string $id)
    {
        $guardia = Guardia::findOrFail($id);
        $guardia->activo = true;
        $guardia->save();

        return redirect()->route('admin.guardias.create')
            ->with('success', 'El guardia ' . $guardia->nombre . ' ' . $guardia->apellido . ' ha sido reactivado exitosamente.');
    }
}