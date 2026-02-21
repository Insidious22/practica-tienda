@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/diccionario.css'])
@endpush

@section('content')
    <div class="header">
        <h2 class="title">Diccionario</h2>
        <div class="header-actions">
            <a href="{{ route('admin.diccionario.create') }}" class="btn primary" data-turbo-frame="_top">Nuevo registro</a>
        </div>
    </div>

    <form
        method="GET"
        action="{{ route('admin.diccionario.index') }}"
        class="form-row"
        data-turbo-frame="admin-diccionario-results"
        data-turbo-action="advance"
    >
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
            <a href="{{ route('admin.diccionario.index') }}" class="btn secondary" data-turbo-frame="admin-diccionario-results" data-turbo-action="advance">Limpiar</a>
        </div>
    </form>

    <turbo-frame id="admin-diccionario-results" class="admin-results-frame">
        <div class="admin-results-skeleton" aria-hidden="true">
            @for($i = 0; $i < 8; $i++)
                <div class="admin-results-skeleton-row">
                    <span class="admin-results-skeleton-line admin-results-skeleton-line--sm"></span>
                    <span class="admin-results-skeleton-line admin-results-skeleton-line--sm"></span>
                    <span class="admin-results-skeleton-line admin-results-skeleton-line--md"></span>
                    <span class="admin-results-skeleton-line admin-results-skeleton-line--sm"></span>
                    <span class="admin-results-skeleton-line admin-results-skeleton-line--md"></span>
                    <span class="admin-results-skeleton-line admin-results-skeleton-line--sm"></span>
                    <span class="admin-results-skeleton-line admin-results-skeleton-line--sm"></span>
                    <span class="admin-results-skeleton-line admin-results-skeleton-line--md"></span>
                </div>
            @endfor
        </div>

        <div class="admin-results-content">
            @if ($registros->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">Diccionario</div>
                    <p class="empty-state-text">No hay registros cargados.</p>
                    <a href="{{ route('admin.diccionario.create') }}" class="btn primary" data-turbo-frame="_top">Crear registro</a>
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
                                    <a href="{{ route('admin.diccionario.edit', $registro) }}" class="btn secondary" data-turbo-frame="_top">Editar</a>
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

                @include('admin._frame-pagination', ['paginator' => $registros, 'frameId' => 'admin-diccionario-results'])
            @endif
        </div>
    </turbo-frame>
@endsection
