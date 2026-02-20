@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/diccionario.css'])
@endpush

@section('content')
    <div class="header">
        <h2 class="title">Diccionario</h2>
        <div class="header-actions">
            <a href="{{ route('admin.diccionario.create') }}" class="btn primary">Nuevo registro</a>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.diccionario.index') }}" class="form-row">
        <div class="form-group">
            <label for="tipo">Filtrar por tipo</label>
            <select id="tipo" name="tipo">
                <option value="">Todos</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo }}" @selected($tipoFiltro === $tipo)>{{ \App\Models\Diccionario::tipoLabel($tipo) }} ({{ $tipo }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-group--align-end">
            <button type="submit" class="btn secondary">Aplicar</button>
            <a href="{{ route('admin.diccionario.index') }}" class="btn secondary">Limpiar</a>
        </div>
    </form>

    @if ($registros->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">Diccionario</div>
            <p class="empty-state-text">No hay registros cargados.</p>
            <a href="{{ route('admin.diccionario.create') }}" class="btn primary">Crear registro</a>
        </div>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Orden</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>ID Cliente</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($registros as $registro)
                <tr>
                    <td>{{ $registro->id }}</td>
                    <td>{{ $registro->orden }}</td>
                    <td><span class="badge primary">{{ \App\Models\Diccionario::tipoLabel($registro->tabla) }} ({{ $registro->tabla }})</span></td>
                    <td>{{ $registro->valor }}</td>
                    <td>{{ $registro->descripcion }}</td>
                    <td>{{ $registro->estado }}</td>
                    <td>{{ $registro->id_cliente ?? '-' }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.diccionario.edit', $registro) }}" class="btn secondary">Editar</a>
                            <form action="{{ route('admin.diccionario.destroy', $registro) }}" method="POST" onsubmit="return confirm('Eliminar registro de diccionario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn danger">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $registros->links() }}
        </div>
    @endif
@endsection
