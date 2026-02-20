@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/dashboard.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">📊 Dashboard</h1>
</div>

<div class="dashboard-section dashboard-export-section">
    <h2 class="dashboard-section-title">⬇️ Exportar Datos</h2>
    <form action="{{ route('admin.export.data') }}" method="GET" class="dashboard-export-form">
        <div>
            <label for="dataset" class="form-label">Módulo</label>
            <select name="dataset" id="dataset" class="form-select" required>
                <option value="categorias" {{ request('dataset', 'categorias') === 'categorias' ? 'selected' : '' }}>Categorías</option>
                <option value="productos" {{ request('dataset') === 'productos' ? 'selected' : '' }}>Productos</option>
                <option value="zonas" {{ request('dataset') === 'zonas' ? 'selected' : '' }}>Zonas</option>
                <option value="proveedores" {{ request('dataset') === 'proveedores' ? 'selected' : '' }}>Proveedores</option>
                <option value="usuarios" {{ request('dataset') === 'usuarios' ? 'selected' : '' }}>Usuarios</option>
                <option value="clientes" {{ request('dataset') === 'clientes' ? 'selected' : '' }}>Clientes</option>
            </select>
        </div>

        <div>
            <label for="format" class="form-label">Formato</label>
            <select name="format" id="format" class="form-select" required>
                <option value="csv" {{ request('format', 'csv') === 'csv' ? 'selected' : '' }}>CSV</option>
                <option value="xlsx" {{ request('format') === 'xlsx' ? 'selected' : '' }}>XLSX</option>
            </select>
        </div>

        <div>
            <label for="start_date" class="form-label">Desde</label>
            <input
                type="date"
                id="start_date"
                name="start_date"
                class="form-control"
                value="{{ request('start_date', now()->subDays(30)->toDateString()) }}"
                required
            >
        </div>

        <div>
            <label for="end_date" class="form-label">Hasta</label>
            <input
                type="date"
                id="end_date"
                name="end_date"
                class="form-control"
                value="{{ request('end_date', now()->toDateString()) }}"
                required
            >
        </div>

        <div class="dashboard-export-button-wrap">
            <button type="submit" class="btn btn-primary">Exportar</button>
        </div>
    </form>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-label">Productos Totales</div>
        <div class="stat-value">{{ $totalProducts }}</div>
        <div class="muted" style="margin-top: 8px;">Productos registrados</div>
    </div>

    <div class="stat-card success">
        <div class="stat-label">Categorías</div>
        <div class="stat-value">{{ $totalCategories }}</div>
        <div class="muted" style="margin-top: 8px;">Categorías creadas</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-label">Zonas</div>
        <div class="stat-value">{{ $totalZones }}</div>
        <div class="muted" style="margin-top: 8px;">Zonas definidas</div>
    </div>

    <div class="stat-card danger">
        <div class="stat-label">Stock Bajo</div>
        <div class="stat-value">{{ $lowStockProducts }}</div>
        <div class="muted" style="margin-top: 8px;">Productos por completar</div>
    </div>
</div>

<!-- Recent Products -->
<div class="dashboard-section">
    <h2 class="dashboard-section-title">📦 Productos Recientes</h2>
    
    @if($recentProducts->count() > 0)
        <div class="dashboard-table-container">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentProducts as $product)
                        <tr>
                            <td><strong>#{{ $product->id }}</strong></td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                <br>
                                <span class="muted">{{ $product->barcode }}</span>
                            </td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>${{ $product->price ? number_format($product->price, 2, ',', '.') : '-' }}</td>
                            <td>
                                <span class="badge @if($product->stock_quantity < 5) danger @elseif($product->stock_quantity < 20) warning @else success @endif">
                                    {{ $product->stock_quantity }} {{ $product->unit }}
                                </span>
                            </td>
                            <td>
                                <span class="badge @if($product->status === 'ACT') success @elseif($product->status === 'INA') warning @else danger @endif">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <div class="empty-state-text">No hay productos registrados</div>
            <a href="{{ route('admin.productos.create') }}" class="btn btn-primary">Crear primer producto</a>
        </div>
    @endif
</div>

<!-- Categories Overview -->
<div class="dashboard-section">
    <h2 class="dashboard-section-title">🏷️ Categorías</h2>
    
    @if($categories->count() > 0)
        <div class="dashboard-categories-grid">
            @foreach($categories as $category)
                <div class="dashboard-category-card">
                    <h3 class="dashboard-category-title">{{ $category->name }}</h3>
                    <p class="muted dashboard-category-desc">{{ $category->description ?? 'Sin descripción' }}</p>
                    <div class="dashboard-category-zone">
                         Zona: {{ $category->zone->name ?? 'N/A' }}
                    </div>
                    <div class="dashboard-category-count">
                        {{ $category->products_count ?? 0 }} productos
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🏷️</div>
            <div class="empty-state-text">No hay categorías registradas</div>
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary">Crear primera categoría</a>
        </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="dashboard-actions-section">
    <h2 class="dashboard-section-title">⚡ Acciones Rápidas</h2>
    
    <div class="dashboard-actions-grid">
        <a href="{{ route('admin.productos.create') }}" class="btn btn-primary dashboard-action-btn">
            <span>➕ Nuevo Producto</span>
        </a>
        <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary dashboard-action-btn">
            <span>➕ Nueva Categoría</span>
        </a>
        <a href="{{ route('admin.zonas.create') }}" class="btn btn-primary dashboard-action-btn">
            <span>➕ Nueva Zona</span>
        </a>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary dashboard-action-btn">
            <span>📋 Ver Todos los Productos</span>
        </a>
    </div>
</div>

@endsection


