@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">🏷️ Detalle de Categoría: {{ $category->name }}</h1>
    <div class="header-actions">
        <a class="btn btn-secondary category-btn-gap-sm" href="{{ route('admin.categorias.edit', $category) }}">✏️ Editar</a>
        <a class="btn btn-secondary category-btn-gap-sm" href="{{ route('admin.categorias.index') }}">← Volver</a>
    </div>
</div>

<!-- Category Details Card -->
<div class="category-show-header">
    <div class="category-show-header-grid">
        <div>
            <h2 class="category-show-title">{{ $category->name }}</h2>
            <p class="category-show-description">{{ $category->description ?: 'Sin descripción' }}</p>
        </div>
        <div class="category-show-zone-section">
            <div class="category-show-zone-label">📍 Zona Asociada</div>
            <div class="category-show-zone-name">
                {{ $category->zone->name ?? 'Sin zona' }}
            </div>
        </div>
    </div>
</div>

<!-- Information Grid -->
<div class="category-info-grid">
    <!-- Basic Info -->
    <div class="category-info-card">
        <h3 class="category-info-card-title">ℹ️ Información</h3>
        <div class="category-info-card-section">
            <span class="muted">ID:</span>
            <div class="category-info-card-value">#{{ $category->id }}</div>
        </div>
        @if($category->code)
            <div>
                <span class="muted">Código:</span>
                <div class="category-info-card-value">{{ $category->code }}</div>
            </div>
        @endif
    </div>

    <!-- Zone Info -->
    <div class="category-info-card">
        <h3 class="category-info-card-title">📍 Zona</h3>
        <div class="category-info-card-value category-info-card-value--large">
            {{ $category->zone->name ?? 'Sin asignar' }}
        </div>
        <div class="muted">{{ $category->zone->description ?? 'Sin descripción' }}</div>
    </div>

    <!-- Statistics -->
    <div class="category-info-card category-info-card--green">
        <h3 class="category-info-card-title">📦 Estadísticas</h3>
        <div class="category-stats-value">
            {{ $category->products->count() }}
        </div>
        <div class="muted">Productos en esta categoría</div>
    </div>
</div>

<!-- Products List -->
<div class="category-products-section">
    <h2 class="category-products-title">📦 Productos en esta Categoría</h2>
    
    @if($category->products->count() > 0)
        <div class="category-products-table-container">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Código de Barras</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->products as $product)
                        <tr>
                            <td><strong>#{{ $product->id }}</strong></td>
                            <td>{{ $product->name }}</td>
                            <td><span class="badge primary">{{ $product->barcode }}</span></td>
                            <td>${{ $product->price ? number_format($product->price, 2, ',', '.') : '-' }}</td>
                            <td>
                                <span class="badge @if($product->stock_quantity < 5) danger @elseif($product->stock_quantity < 20) warning @else success @endif">
                                    {{ $product->stock_quantity }} {{ $product->unit }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-secondary" href="{{ route('admin.productos.show', $product) }}" title="Ver">👁️</a>
                                    <a class="btn btn-secondary" href="{{ route('admin.productos.edit', $product) }}" title="Editar">✏️</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state category-empty-state">
            <div class="empty-state-icon">📦</div>
            <div class="empty-state-text">No hay productos en esta categoría</div>
            <a href="{{ route('admin.productos.create') }}" class="btn btn-primary">Crear primer producto</a>
        </div>
    @endif
</div>

<!-- Action Buttons -->
<div class="category-actions-container">
    <a class="btn btn-primary category-btn-gap-sm" href="{{ route('admin.categorias.edit', $category) }}">✏️ Editar Categoría</a>
    <a class="btn btn-secondary category-btn-gap-sm" href="{{ route('admin.categorias.index') }}">← Volver a Lista</a>
    <form action="{{ route('admin.categorias.destroy', $category) }}" method="POST" class="category-delete-form">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger category-btn-gap-sm" type="submit" onclick="return confirm('¿Eliminar esta categoría? También se eliminarán sus productos.')">🗑️ Eliminar</button>
    </form>
</div>

@endsection
