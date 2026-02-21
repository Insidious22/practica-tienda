@extends('layouts.app')

@section('content')
    <div class="header">
        <h2 class="title">Detalle de Guardia</h2>
        <div class="header-actions">
            <a href="{{ route('admin.guardias.index') }}" class="btn secondary">Volver</a>
            <a href="{{ route('admin.guardias.edit', $guardia) }}" class="btn primary">Editar</a>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Nombre</label>
            <div>{{ $guardia->nombre }} {{ $guardia->apellido }}</div>
        </div>
        <div class="form-group">
            <label>Cedula</label>
            <div>{{ $guardia->cedula }}</div>
        </div>
        <div class="form-group">
            <label>Turno</label>
            <div>{{ $guardia->turno }}</div>
        </div>
        <div class="form-group">
            <label>Codigo</label>
            <div>{{ $guardia->codigo_unico ?? '-' }}</div>
        </div>
    </div>

    <div class="header section-header">
        <h3 class="title section-title">Equipamiento asignado</h3>
    </div>

    @if ($guardia->items->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">Items</div>
            <p class="empty-state-text">Este guardia no tiene items asignados.</p>
        </div>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>Item</th>
                <th>Codigo</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($guardia->items as $item)
                <tr>
                    <td>{{ $item->nombre_item ?? ($item->inventoryItem->nombre ?? '-') }}</td>
                    <td>{{ $item->codigo_serie ?? ($item->inventoryItem->codigo_serie ?? '-') }}</td>
                    <td>
                        <form action="{{ route('admin.guardias.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Quitar este item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn danger">Quitar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <div class="header section-header">
        <h3 class="title section-title">Agregar item</h3>
    </div>

    <form action="{{ route('admin.guardias.addItem', $guardia) }}" method="POST" class="form-row">
        @csrf
        <div class="form-group">
            <label for="inventory_item_id">Inventario</label>
            <select id="inventory_item_id" name="inventory_item_id" required>
                @foreach ($inventarioItems as $inv)
                    <option value="{{ $inv->id }}">{{ $inv->nombre }} ({{ $inv->cantidad }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-group--align-end">
            <button type="submit" class="btn success">Agregar</button>
        </div>
    </form>
@endsection
