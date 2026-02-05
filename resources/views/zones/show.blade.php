@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">📍 Detalle de Zona: {{ $zone->name }}</h1>
    <div class="header-actions">
        <a class="btn secondary" href="{{ route('admin.zonas.edit', $zone) }}" style="gap: 6px;">✏️ Editar</a>
        <a class="btn secondary" href="{{ route('admin.zonas.index') }}" style="gap: 6px;">← Volver</a>
    </div>
</div>

<!-- Zone Details Card -->
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 24px; color: white; margin-bottom: 30px;">
    <div>
        <h2 style="margin: 0 0 8px 0; font-size: 28px;">{{ $zone->name }}</h2>
        <p style="margin: 0; opacity: 0.9;">{{ $zone->description ?: 'Sin descripción' }}</p>
    </div>
</div>

<!-- Information Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <!-- Basic Info -->
    <div style="background: #f9fafb; border-radius: 10px; padding: 16px; border-left: 4px solid #667eea;">
        <h3 style="margin: 0 0 12px 0; color: #1f2937; font-weight: 600;">ℹ️ Información</h3>
        <div style="margin-bottom: 12px;">
            <span class="muted">ID:</span>
            <div style="font-weight: 600; color: #1f2937; margin-top: 4px;">#{{ $zone->id }}</div>
        </div>
        <div>
            <span class="muted">Código:</span>
            <div style="font-weight: 600; color: #1f2937; margin-top: 4px;">{{ $zone->code }}</div>
        </div>
    </div>

    <!-- Statistics -->
    <div style="background: #f9fafb; border-radius: 10px; padding: 16px; border-left: 4px solid #10b981;">
        <h3 style="margin: 0 0 12px 0; color: #1f2937; font-weight: 600;">📊 Estadísticas</h3>
        <div style="margin-bottom: 12px;">
            <div style="font-size: 28px; font-weight: 700; color: #10b981;">{{ $zone->categories->count() }}</div>
            <div class="muted">Categorías en esta zona</div>
        </div>
        <div>
            <div style="font-size: 24px; font-weight: 700; color: #667eea;">{{ $zone->categories->flatMap->products->count() }}</div>
            <div class="muted">Productos totales</div>
        </div>
    </div>
</div>

<!-- Categories List -->
<div style="margin-bottom: 30px;">
    <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1f2937;">🏷️ Categorías en esta Zona</h2>
    
    @if($zone->categories->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 16px;">
            @foreach($zone->categories as $category)
                <div style="background: white; border-radius: 10px; padding: 14px; border: 1px solid #e5e7eb;">
                    <h4 style="margin: 0 0 8px 0; color: #1f2937; font-weight: 600;">{{ $category->name }}</h4>
                    @if($category->code)
                        <div class="muted" style="font-size: 12px; margin-bottom: 8px;">Código: {{ $category->code }}</div>
                    @endif
                    <div class="muted" style="font-size: 13px;">{{ $category->products->count() }} productos</div>
                    <a class="btn secondary" href="{{ route('admin.categorias.show', $category) }}" style="margin-top: 10px; width: 100%; text-align: center; padding: 8px 12px; font-size: 12px;">Ver categoría →</a>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state" style="padding: 40px 20px;">
            <div class="empty-state-icon">🏷️</div>
            <div class="empty-state-text">No hay categorías en esta zona</div>
            <a href="{{ route('admin.categorias.create') }}" class="btn primary">Crear primera categoría</a>
        </div>
    @endif
</div>

<!-- Action Buttons -->
<div style="display: flex; gap: 12px; margin-bottom: 30px; flex-wrap: wrap;">
    <a class="btn primary" href="{{ route('admin.zonas.edit', $zone) }}" style="gap: 6px;">✏️ Editar Zona</a>
    <a class="btn secondary" href="{{ route('admin.zonas.index') }}" style="gap: 6px;">← Volver a Lista</a>
    <form action="{{ route('admin.zonas.destroy', $zone) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button class="btn danger" type="submit" onclick="return confirm('¿Eliminar esta zona? También se eliminarán sus categorías.')" style="gap: 6px;">🗑️ Eliminar</button>
    </form>
</div>

@endsection
