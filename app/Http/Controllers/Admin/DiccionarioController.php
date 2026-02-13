<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diccionario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiccionarioController extends Controller
{
    public function index(Request $request)
    {
        $tipoFiltro = $request->query('tipo');

        $query = Diccionario::query()->orderBy('tipo')->orderBy('numero');

        if (!empty($tipoFiltro)) {
            $query->where('tipo', $tipoFiltro);
        }

        $registros = $query->paginate(20)->withQueryString();
        $tipos = Diccionario::query()->select('tipo')->distinct()->orderBy('tipo')->pluck('tipo');

        return view('admin.diccionario.index', compact('registros', 'tipos', 'tipoFiltro'));
    }

    public function create()
    {
        return view('admin.diccionario.create');
    }

    public function store(Request $request)
    {
        $data = $this->validar($request);
        Diccionario::create($data);

        return redirect()->route('admin.diccionario.index')
            ->with('success', 'Registro de diccionario creado correctamente.');
    }

    public function edit(Diccionario $diccionario)
    {
        return view('admin.diccionario.edit', compact('diccionario'));
    }

    public function update(Request $request, Diccionario $diccionario)
    {
        $data = $this->validar($request, $diccionario->id);
        $diccionario->update($data);

        return redirect()->route('admin.diccionario.index')
            ->with('success', 'Registro de diccionario actualizado correctamente.');
    }

    public function destroy(Diccionario $diccionario)
    {
        $diccionario->delete();

        return redirect()->route('admin.diccionario.index')
            ->with('success', 'Registro de diccionario eliminado correctamente.');
    }

    private function validar(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'numero' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('diccionario', 'numero')
                    ->where(fn ($query) => $query->where('tipo', $request->input('tipo')))
                    ->ignore($id),
            ],
            'tipo' => ['required', 'string', 'max:100'],
            'descripcion' => [
                'required',
                'string',
                'max:150',
                Rule::unique('diccionario', 'descripcion')
                    ->where(fn ($query) => $query->where('tipo', $request->input('tipo')))
                    ->ignore($id),
            ],
            'siglas' => [
                'required',
                'string',
                'min:2',
                'max:3',
                'regex:/^[A-Z0-9]{2,3}$/',
                Rule::unique('diccionario', 'siglas')
                    ->where(fn ($query) => $query->where('tipo', $request->input('tipo')))
                    ->ignore($id),
            ],
        ]);
    }
}
