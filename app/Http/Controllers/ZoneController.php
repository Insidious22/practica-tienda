<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::orderByDesc('id')->paginate(15);
        return view('zones.index', compact('zones'));
    }

    public function create()
    {
        return view('zones.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:32|unique:zones,code',
            'name' => 'required|string|max:128|unique:zones,name',
            'description' => 'nullable|string',
        ]);

        Zone::create($data);

        return redirect()->route('zonas.index')->with('success', 'Zona creada correctamente.');
    }

    public function show(Zone $zona)
    {
        return view('zones.show', ['zone' => $zona]);
    }

    public function edit(Zone $zona)
    {
        return view('zones.edit', ['zone' => $zona]);
    }

    public function update(Request $request, Zone $zona)
    {
        $data = $request->validate([
            'code' => 'required|string|max:32|unique:zones,code,' . $zona->id,
            'name' => 'required|string|max:128|unique:zones,name,' . $zona->id,
            'description' => 'nullable|string',
        ]);

        $zona->update($data);

        return redirect()->route('zonas.index')->with('success', 'Zona actualizada correctamente.');
    }

    public function destroy(Zone $zona)
    {
        if ($zona->categories()->exists()) {
            return redirect()->route('zonas.index')->with('error', 'No se puede eliminar una zona con categorías asociadas.');
        }

        $zona->delete();

        return redirect()->route('zonas.index')->with('success', 'Zona eliminada correctamente.');
    }
}
