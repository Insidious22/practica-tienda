@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">📊 Dashboard</h1>
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
<div style="margin-top: 40px;">
    <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1f2937;">📦 Productos Recientes</h2>
    
    @if($recentProducts->count() > 0)
        <div style="overflow-x: auto;">
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
                                <span class="badge @if($product->status === 'active') success @elseif($product->status === 'inactive') warning @else danger @endif">
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
<div style="margin-top: 40px;">
    <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1f2937;">🏷️ Categorías</h2>
    
    @if($categories->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            @foreach($categories as $category)
                <div style="background: #f9fafb; border-radius: 10px; padding: 16px; border-left: 4px solid #667eea;">
                    <h3 style="margin: 0 0 8px 0; color: #1f2937; font-weight: 600;">{{ $category->name }}</h3>
                    <p class="muted" style="margin: 0 0 12px 0;">{{ $category->description ?? 'Sin descripción' }}</p>
                    <div style="font-size: 12px; color: #667eea; font-weight: 600;">
                         Zona: {{ $category->zone->name ?? 'N/A' }}
                    </div>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 8px;">
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
<div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
    <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1f2937;">⚡ Acciones Rápidas</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
        <a href="{{ route('admin.productos.create') }}" class="btn btn-primary" style="justify-content: center;">
            <span>➕ Nuevo Producto</span>
        </a>
        <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary" style="justify-content: center;">
            <span>➕ Nueva Categoría</span>
        </a>
        <a href="{{ route('admin.zonas.create') }}" class="btn btn-primary" style="justify-content: center;">
            <span>➕ Nueva Zona</span>
        </a>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary" style="justify-content: center;">
            <span>📋 Ver Todos los Productos</span>
        </a>
    </div>
</div>

@endsection
