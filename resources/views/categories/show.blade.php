@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">🏷️ Detalle de Categoría: {{ $category->name }}</h1>
    <div class="header-actions">
        <a class="btn secondary" href="{{ route('admin.categorias.edit', $category) }}" style="gap: 6px;">✏️ Editar</a>
        <a class="btn secondary" href="{{ route('admin.categorias.index') }}" style="gap: 6px;">← Volver</a>
    </div>
</div>

<!-- Category Details Card -->
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 24px; color: white; margin-bottom: 30px;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <h2 style="margin: 0 0 8px 0; font-size: 24px;">{{ $category->name }}</h2>
            <p style="margin: 0; opacity: 0.9;">{{ $category->description ?: 'Sin descripción' }}</p>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 16px; opacity: 0.9;">📍 Zona Asociada</div>
            <div style="font-size: 24px; font-weight: 700; margin-top: 8px;">
                {{ $category->zone->name ?? 'Sin zona' }}
            </div>
        </div>
    </div>
</div>

<!-- Information Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <!-- Basic Info -->
    <div style="background: #f9fafb; border-radius: 10px; padding: 16px; border-left: 4px solid #667eea;">
        <h3 style="margin: 0 0 12px 0; color: #1f2937; font-weight: 600;">ℹ️ Información</h3>
        <div style="margin-bottom: 12px;">
            <span class="muted">ID:</span>
            <div style="font-weight: 600; color: #1f2937; margin-top: 4px;">#{{ $category->id }}</div>
        </div>
        @if($category->code)
            <div>
                <span class="muted">Código:</span>
                <div style="font-weight: 600; color: #1f2937; margin-top: 4px;">{{ $category->code }}</div>
            </div>
        @endif
    </div>

    <!-- Zone Info -->
    <div style="background: #f9fafb; border-radius: 10px; padding: 16px; border-left: 4px solid #667eea;">
        <h3 style="margin: 0 0 12px 0; color: #1f2937; font-weight: 600;">📍 Zona</h3>
        <div style="font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 8px;">
            {{ $category->zone->name ?? 'Sin asignar' }}
        </div>
        <div class="muted">{{ $category->zone->description ?? 'Sin descripción' }}</div>
    </div>

    <!-- Statistics -->
    <div style="background: #f9fafb; border-radius: 10px; padding: 16px; border-left: 4px solid #10b981;">
        <h3 style="margin: 0 0 12px 0; color: #1f2937; font-weight: 600;">📦 Estadísticas</h3>
        <div style="font-size: 28px; font-weight: 700; color: #10b981;">
            {{ $category->products->count() }}
        </div>
        <div class="muted">Productos en esta categoría</div>
    </div>
</div>

<!-- Products List -->
<div style="margin-bottom: 30px;">
    <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1f2937;">📦 Productos en esta Categoría</h2>
    
    @if($category->products->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table">
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
                                    <a class="btn secondary" href="{{ route('admin.productos.show', $product) }}" title="Ver">👁️</a>
                                    <a class="btn secondary" href="{{ route('admin.productos.edit', $product) }}" title="Editar">✏️</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state" style="padding: 40px 20px;">
            <div class="empty-state-icon">📦</div>
            <div class="empty-state-text">No hay productos en esta categoría</div>
            <a href="{{ route('admin.productos.create') }}" class="btn primary">Crear primer producto</a>
        </div>
    @endif
</div>

<!-- Action Buttons -->
<div style="display: flex; gap: 12px; margin-bottom: 30px; flex-wrap: wrap;">
    <a class="btn primary" href="{{ route('admin.categorias.edit', $category) }}" style="gap: 6px;">✏️ Editar Categoría</a>
    <a class="btn secondary" href="{{ route('admin.categorias.index') }}" style="gap: 6px;">← Volver a Lista</a>
    <form action="{{ route('admin.categorias.destroy', $category) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button class="btn danger" type="submit" onclick="return confirm('¿Eliminar esta categoría? También se eliminarán sus productos.')" style="gap: 6px;">🗑️ Eliminar</button>
    </form>
</div>

@endsection
