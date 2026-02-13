@extends('layouts.app')

@section('content')
    <div class="header">
        <h2 class="title">Editar Guardia</h2>
        <div class="header-actions">
            <a href="{{ route('admin.guardias.index') }}" class="btn secondary">Volver</a>
        </div>
    </div>

    <form action="{{ route('admin.guardias.update', $guardia) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $guardia->nombre) }}" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $guardia->apellido) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tipo_documento">Tipo de documento</label>
                <select id="tipo_documento" name="tipo_documento" required>
                    @foreach ($tiposDocumento as $tipo)
                        <option value="{{ $tipo->siglas }}" @selected(old('tipo_documento', $guardia->tipo_documento) === $tipo->siglas)>{{ $tipo->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="cedula">Cedula/Documento</label>
                <input type="text" id="cedula" name="cedula" value="{{ old('cedula', $guardia->cedula) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="turno">Turno</label>
                <select id="turno" name="turno" required>
                    @foreach ($turnos as $turno)
                        <option value="{{ $turno->siglas }}" @selected(old('turno', $guardia->turno) === $turno->siglas)>{{ $turno->descripcion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn primary">Guardar cambios</button>
            <a href="{{ route('admin.guardias.index') }}" class="btn secondary">Cancelar</a>
        </div>
    </form>
@endsection
