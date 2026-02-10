@extends('layouts.app')

@section('content')
    <div class="header">
        <h2 class="title">Guardias</h2>
        <div class="header-actions">
            <a href="{{ route('admin.guardias.create') }}" class="btn primary">Nuevo guardia</a>
        </div>
    </div>

    @if ($guardias->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">Guardias</div>
            <p class="empty-state-text">No hay guardias registrados.</p>
            <a href="{{ route('admin.guardias.create') }}" class="btn primary">Registrar guardia</a>
        </div>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cedula</th>
                <th>Turno</th>
                <th>Codigo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($guardias as $guardia)
                <tr>
                    <td>{{ $guardia->id }}</td>
                    <td>{{ $guardia->nombre }} {{ $guardia->apellido }}</td>
                    <td>{{ $guardia->cedula }}</td>
                    <td>{{ $guardia->turno }}</td>
                    <td>{{ $guardia->codigo_unico ?? '-' }}</td>
                    <td>
                        @if($guardia->activo)
                            <span class="badge success">Activo</span>
                        @else
                            <span class="badge danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.guardias.show', $guardia) }}" class="btn secondary">Ver</a>
                            <a href="{{ route('admin.guardias.edit', $guardia) }}" class="btn secondary">Editar</a>
                            <form action="{{ route('admin.guardias.destroy', $guardia) }}" method="POST" onsubmit="return confirm('Marcar guardia como inactivo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn danger">Inactivar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
