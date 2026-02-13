@extends('layouts.app')

@push('styles')
    @vite(['resources/css/admin/products.css'])
@endpush

@section('content')
@php
    $stockLevel = $product->stock_quantity < 5 ? 'critical' : ($product->stock_quantity < 20 ? 'low' : 'ok');
@endphp
<div class="header">
    <h1 class="title">📦 Detalle del Producto</h1>
    <div class="header-actions">
        <a class="btn btn-secondary product-action-btn" href="{{ route('admin.productos.edit', $product) }}">✏️ Editar</a>
        <a class="btn btn-secondary product-action-btn" href="{{ route('admin.productos.index') }}">← Volver</a>
    </div>
</div>

<!-- Product Details Card -->
<div class="product-hero">
    <div class="product-hero-grid">
        <div>
            <h2 class="product-hero-title">{{ $product->name }}</h2>
            <p class="product-hero-desc">{{ $product->description ?: 'Sin descripción' }}</p>
        </div>
        <div class="product-hero-meta">
            <div class="product-hero-price">
                @if($product->price)
                    ${{ number_format($product->price, 2, ',', '.') }}
                @else
                    <span class="product-hero-price-muted">No definido</span>
                @endif
            </div>
            <span class="badge product-status-badge @if($product->status === 'ACT') success @elseif($product->status === 'INA') warning @else danger @endif">
                @if($product->status === 'ACT')
                    ✓ Activo
                @elseif($product->status === 'INA')
                    ⊘ Inactivo
                @else
                    ✗ Descontinuado
                @endif
            </span>
        </div>
    </div>
</div>

<!-- Information Grid -->
<div class="product-info-grid">
    <!-- Codes -->
    <div class="product-info-card">
        <h3 class="product-info-title">📊 Códigos</h3>
        <div class="product-info-block">
            <span class="muted">Código de Barras:</span>
            <div class="product-code">{{ $product->barcode }}</div>
        </div>
        @if($product->sku)
            <div>
                <span class="muted">SKU:</span>
                <div class="product-code">{{ $product->sku }}</div>
            </div>
        @endif
    </div>

    <!-- Stock Info -->
    <div class="product-info-card product-info-card--{{ $stockLevel }}">
        <h3 class="product-info-title">📦 Stock</h3>
        <div class="product-stock-value product-stock-value--{{ $stockLevel }}">
            {{ $product->stock_quantity }}
        </div>
        <div class="muted">{{ $product->unit }}</div>
        @if($product->stock_quantity < 5)
            <div class="product-stock-warning product-stock-warning--critical">⚠️ Stock Crítico</div>
        @elseif($product->stock_quantity < 20)
            <div class="product-stock-warning product-stock-warning--low">⚠️ Stock Bajo</div>
        @endif
    </div>

    <!-- Category Info -->
    <div class="product-info-card">
        <h3 class="product-info-title">🏷️ Clasificación</h3>
        <div class="product-info-block">
            <span class="muted">Categoría:</span>
            <div class="product-info-value">
                {{ $product->category->name ?? 'Sin categoría' }}
            </div>
        </div>
        <div>
            <span class="muted">Zona:</span>
            <div class="product-info-value">
                📍 {{ $product->category->zone->name ?? 'Sin zona' }}
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="product-actions">
    <a class="btn btn-primary product-action-btn" href="{{ route('admin.productos.edit', $product) }}">✏️ Editar Producto</a>
    <a class="btn btn-secondary product-action-btn" href="{{ route('admin.productos.index') }}">← Volver a Lista</a>
    <form action="{{ route('admin.productos.destroy', $product) }}" method="POST" class="product-action-form">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger product-action-btn" type="submit" onclick="return confirm('¿Eliminar este producto? Esta acción no se puede deshacer.')">🗑️ Eliminar</button>
    </form>
</div>

<!-- Metadata -->
<div class="product-meta">
    <strong>Información adicional:</strong> Este producto fue registrado el {{ $product->created_at->format('d/m/Y H:i') }}.
    @if($product->created_at !== $product->updated_at)
        Última modificación: {{ $product->updated_at->format('d/m/Y H:i') }}
    @endif
</div>

@endsection

