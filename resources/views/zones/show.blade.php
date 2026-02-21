@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">Detalle de Zona: {{ $zone->name }}</h1>
    <div class="header-actions">
        <a class="btn btn-secondary zone-action" href="{{ route('admin.zonas.edit', $zone) }}">Editar</a>
        <a class="btn btn-secondary zone-action" href="{{ route('admin.zonas.index') }}">Volver</a>
    </div>
</div>

<div class="zone-hero">
    <div>
        <h2 class="zone-hero-title">{{ $zone->name }}</h2>
        <p class="zone-hero-text">{{ $zone->description ?: 'Sin descripcion' }}</p>
    </div>
</div>

<div class="zone-info-grid">
    <div class="zone-info-card">
        <h3 class="zone-info-title">Informacion</h3>
        <div class="zone-info-item">
            <span class="muted">ID:</span>
            <div class="zone-info-value">#{{ $zone->id }}</div>
        </div>
        <div>
            <span class="muted">Codigo:</span>
            <div class="zone-info-value">{{ $zone->code }}</div>
        </div>
    </div>

    <div class="zone-info-card zone-info-card--success">
        <h3 class="zone-info-title">Estadisticas</h3>
        <div class="zone-info-item">
            <div class="zone-info-stat">{{ $zone->categories->count() }}</div>
            <div class="muted">Categorias en esta zona</div>
        </div>
        <div>
            <div class="zone-info-stat zone-info-stat--primary">{{ $zone->categories->flatMap->products->count() }}</div>
            <div class="muted">Productos totales</div>
        </div>
    </div>
</div>

<div class="zone-categories">
    <h2 class="zone-categories-title">Categorias en esta Zona</h2>

    @if($zone->categories->count() > 0)
        <div class="zone-categories-grid">
            @foreach($zone->categories as $category)
                <div class="zone-category-card">
                    <h4 class="zone-category-title">{{ $category->name }}</h4>
                    @if($category->code)
                        <div class="muted zone-category-code">Codigo: {{ $category->code }}</div>
                    @endif
                    <div class="muted zone-category-count">{{ $category->products->count() }} productos</div>
                    <a class="btn btn-secondary zone-category-link" href="{{ route('admin.categorias.show', $category) }}">Ver categoria</a>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state zone-empty">
            <div class="empty-state-icon">Categorias</div>
            <div class="empty-state-text">No hay categorias en esta zona</div>
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary">Crear primera categoria</a>
        </div>
    @endif
</div>

<div class="zone-actions">
    <a class="btn btn-primary zone-action" href="{{ route('admin.zonas.edit', $zone) }}">Editar Zona</a>
    <a class="btn btn-secondary zone-action" href="{{ route('admin.zonas.index') }}">Volver a Lista</a>
    <form action="{{ route('admin.zonas.destroy', $zone) }}" method="POST" class="zone-action-form">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger zone-action" type="submit" onclick="return confirm('Eliminar esta zona? Tambien se eliminaran sus categorias.')">Eliminar</button>
    </form>
</div>

@endsection
