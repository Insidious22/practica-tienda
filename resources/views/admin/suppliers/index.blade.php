@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/suppliers.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">Proveedores</h1>
    <a href="{{ route('admin.proveedores.create') }}" class="btn btn-primary">
        + Nuevo Proveedor
    </a>
</div>

@if (session('success'))
    <div class="alert success">
        <span>✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if ($suppliers->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th class="admin-table-actions">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->code }}</td>
                    <td>{{ $supplier->business_name }}</td>
                    <td class="admin-table-muted">{{ $supplier->contact_name ?? '-' }}</td>
                    <td class="admin-table-muted">{{ $supplier->phone ?? '-' }}</td>
                    <td>
                        <span class="status-pill {{ $supplier->status === 'ACT' ? 'status-pill--success' : 'status-pill--danger' }}">
                            {{ ucfirst($supplier->status) }}
                        </span>
                    </td>
                    <td class="admin-table-actions">
                        <a href="{{ route('admin.proveedores.show', $supplier) }}" class="action-tag action-tag--info">Ver</a>
                        <a href="{{ route('admin.proveedores.edit', $supplier) }}" class="action-tag action-tag--warn">Editar</a>
                        <form action="{{ route('admin.proveedores.destroy', $supplier) }}" method="POST" class="admin-inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-tag action-tag--danger" onclick="return confirm('¿Seguro que deseas eliminar este proveedor?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="admin-table-pagination">
        {{ $suppliers->links() }}
    </div>
@else
    <div class="admin-empty-card">
        <p class="admin-empty-text">No hay proveedores registrados.</p>
    </div>
@endif
@endsection


