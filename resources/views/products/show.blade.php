@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">📦 Detalle del Producto</h1>
    <div class="header-actions">
        <a class="btn btn-secondary" href="{{ route('admin.productos.edit', $product) }}" style="gap: 6px;">✏️ Editar</a>
        <a class="btn btn-secondary" href="{{ route('admin.productos.index') }}" style="gap: 6px;">← Volver</a>
    </div>
</div>

<!-- Product Details Card -->
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 24px; color: white; margin-bottom: 30px;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <h2 style="margin: 0 0 8px 0; font-size: 20px;">{{ $product->name }}</h2>
            <p style="margin: 0; opacity: 0.9;">{{ $product->description ?: 'Sin descripción' }}</p>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 32px; font-weight: 700;">
                @if($product->price)
                    ${{ number_format($product->price, 2, ',', '.') }}
                @else
                    <span style="font-size: 16px; opacity: 0.8;">No definido</span>
                @endif
            </div>
            <span class="badge @if($product->status === 'active') success @elseif($product->status === 'inactive') warning @else danger @endif" style="margin-top: 8px;">
                @if($product->status === 'active')
                    ✓ Activo
                @elseif($product->status === 'inactive')
                    ⊘ Inactivo
                @else
                    ✗ Descontinuado
                @endif
            </span>
        </div>
    </div>
</div>

<!-- Information Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <!-- Codes -->
    <div style="background: #f9fafb; border-radius: 10px; padding: 16px; border-left: 4px solid #667eea;">
        <h3 style="margin: 0 0 12px 0; color: #1f2937; font-weight: 600;">📊 Códigos</h3>
        <div style="margin-bottom: 10px;">
            <span class="muted">Código de Barras:</span>
            <div style="font-weight: 600; color: #1f2937; font-family: monospace; margin-top: 4px;">{{ $product->barcode }}</div>
        </div>
        @if($product->sku)
            <div>
                <span class="muted">SKU:</span>
                <div style="font-weight: 600; color: #1f2937; font-family: monospace; margin-top: 4px;">{{ $product->sku }}</div>
            </div>
        @endif
    </div>

    <!-- Stock Info -->
    <div style="background: #f9fafb; border-radius: 10px; padding: 16px; border-left: 4px solid @if($product->stock_quantity < 5) #ef4444 @elseif($product->stock_quantity < 20) #f59e0b @else #10b981 @endif;">
        <h3 style="margin: 0 0 12px 0; color: #1f2937; font-weight: 600;">📦 Stock</h3>
        <div style="font-size: 28px; font-weight: 700; color: @if($product->stock_quantity < 5) #ef4444 @elseif($product->stock_quantity < 20) #f59e0b @else #10b981 @endif;">
            {{ $product->stock_quantity }}
        </div>
        <div class="muted">{{ $product->unit }}</div>
        @if($product->stock_quantity < 5)
            <div style="color: #ef4444; font-weight: 600; margin-top: 8px; font-size: 12px;">⚠️ Stock Crítico</div>
        @elseif($product->stock_quantity < 20)
            <div style="color: #f59e0b; font-weight: 600; margin-top: 8px; font-size: 12px;">⚠️ Stock Bajo</div>
        @endif
    </div>

    <!-- Category Info -->
    <div style="background: #f9fafb; border-radius: 10px; padding: 16px; border-left: 4px solid #667eea;">
        <h3 style="margin: 0 0 12px 0; color: #1f2937; font-weight: 600;">🏷️ Clasificación</h3>
        <div style="margin-bottom: 12px;">
            <span class="muted">Categoría:</span>
            <div style="font-weight: 600; color: #1f2937; margin-top: 4px;">
                {{ $product->category->name ?? 'Sin categoría' }}
            </div>
        </div>
        <div>
            <span class="muted">Zona:</span>
            <div style="font-weight: 600; color: #1f2937; margin-top: 4px;">
                📍 {{ $product->category->zone->name ?? 'Sin zona' }}
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div style="display: flex; gap: 12px; margin-bottom: 30px; flex-wrap: wrap;">
    <a class="btn btn-primary" href="{{ route('admin.productos.edit', $product) }}" style="gap: 6px;">✏️ Editar Producto</a>
    <a class="btn btn-secondary" href="{{ route('admin.productos.index') }}" style="gap: 6px;">← Volver a Lista</a>
    <form action="{{ route('admin.productos.destroy', $product) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit" onclick="return confirm('¿Eliminar este producto? Esta acción no se puede deshacer.')" style="gap: 6px;">🗑️ Eliminar</button>
    </form>
</div>

<!-- Metadata -->
<div style="background: #f3f4f6; border-radius: 8px; padding: 12px 16px; color: #6b7280; font-size: 12px;">
    <strong>Información adicional:</strong> Este producto fue registrado el {{ $product->created_at->format('d/m/Y H:i') }}.
    @if($product->created_at !== $product->updated_at)
        Última modificación: {{ $product->updated_at->format('d/m/Y H:i') }}
    @endif
</div>

@endsection
