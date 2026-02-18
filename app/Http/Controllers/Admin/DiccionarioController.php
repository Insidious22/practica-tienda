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
        $tipoFiltro = Diccionario::tipoKey((string) $request->query('tipo', ''));

        $query = Diccionario::query()->orderBy('tabla')->orderBy('orden');

        if (!empty($tipoFiltro)) {
            $query->where('tabla', $tipoFiltro);
        }

        $registros = $query->paginate(20)->withQueryString();
        $tipos = Diccionario::query()->select('tabla')->distinct()->orderBy('tabla')->pluck('tabla');

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
        $tabla = Diccionario::tipoKey((string) $request->input('tabla', $request->input('tipo', '')));
        $valor = Diccionario::resolverValor(
            $request->input('valor', $request->input('siglas')),
            (string) $request->input('descripcion', '')
        );

        $request->merge([
            'tabla' => $tabla,
            'valor' => $valor,
            'estado' => strtoupper((string) $request->input('estado', 'A')),
        ]);

        return $request->validate([
            'orden' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('diccionario', 'orden')
                    ->where(fn ($query) => $query->where('tabla', $tabla))
                    ->ignore($id),
            ],
            'id_cliente' => ['nullable', 'integer', 'min:1'],
            'tabla' => ['required', 'string', 'max:255'],
            'valor' => [
                'required',
                'string',
                'max:255',
                Rule::unique('diccionario', 'valor')
                    ->where(fn ($query) => $query->where('tabla', $tabla))
                    ->ignore($id),
            ],
            'descripcion' => [
                'required',
                'string',
                'max:255',
            ],
            'estado' => ['required', 'string', 'size:1', Rule::in(['A', 'I'])],
        ]);
    }
}
