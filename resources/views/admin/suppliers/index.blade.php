@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/suppliers.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">Proveedores</h1>
    <a href="{{ route('admin.proveedores.create') }}" class="btn btn-primary" data-turbo-frame="_top">
        + Nuevo Proveedor
    </a>
</div>

@if (session('success'))
    <div class="alert success">
        <span>OK</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

<turbo-frame id="admin-suppliers-results" class="admin-results-frame">
    <div class="admin-results-skeleton" aria-hidden="true">
        @for($i = 0; $i < 8; $i++)
            <div class="admin-results-skeleton-row">
                <span class="admin-results-skeleton-line admin-results-skeleton-line--sm"></span>
                <span class="admin-results-skeleton-line admin-results-skeleton-line--lg"></span>
                <span class="admin-results-skeleton-line admin-results-skeleton-line--md"></span>
                <span class="admin-results-skeleton-line admin-results-skeleton-line--sm"></span>
                <span class="admin-results-skeleton-line admin-results-skeleton-line--sm"></span>
                <span class="admin-results-skeleton-line admin-results-skeleton-line--md"></span>
            </div>
        @endfor
    </div>

    <div class="admin-results-content">
        @if ($suppliers->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Telefono</th>
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
                                <a href="{{ route('admin.proveedores.show', $supplier) }}" class="action-tag action-tag--info" data-turbo-frame="_top">Ver</a>
                                <a href="{{ route('admin.proveedores.edit', $supplier) }}" class="action-tag action-tag--warn" data-turbo-frame="_top">Editar</a>
                                <form action="{{ route('admin.proveedores.destroy', $supplier) }}" method="POST" class="admin-inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-tag action-tag--danger" onclick="return confirm('Seguro que deseas eliminar este proveedor?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @include('admin._frame-pagination', ['paginator' => $suppliers, 'frameId' => 'admin-suppliers-results'])
        @else
            <div class="admin-empty-card">
                <p class="admin-empty-text">No hay proveedores registrados.</p>
            </div>
        @endif
    </div>
</turbo-frame>
@endsection
