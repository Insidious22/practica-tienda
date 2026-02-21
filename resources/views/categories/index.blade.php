@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">🏷️ Gestión de Categorías</h1>
    <div class="header-actions">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Buscar categorías..." class="category-search-input">
        </div>
        <a class="btn btn-primary" href="{{ route('admin.categorias.create') }}">➕ Nueva Categoría</a>
    </div>
</div>

@if ($categories->count() === 0)
    <div class="empty-state">
        <div class="empty-state-icon">🏷️</div>
        <div class="empty-state-text">No hay categorías registradas</div>
        <a class="btn btn-primary" href="{{ route('admin.categorias.create') }}">Crear primera categoría</a>
    </div>
@else
    <div class="categories-grid">
        @foreach ($categories as $category)
            <div class="category-card">
                <div class="category-card-header">
                    <h3 class="category-card-title">{{ $category->name }}</h3>
                    @if($category->code)
                        <span class="muted category-card-code">Código: {{ $category->code }}</span>
                    @endif
                </div>
                <div class="category-card-body">
                    <div class="category-card-section">
                        <span class="muted">📍 Zona:</span>
                        <div class="category-zone-name">{{ $category->zone->name ?? 'Sin zona' }}</div>
                    </div>
                    @if($category->description)
                        <div class="category-card-section">
                            <span class="muted">Descripción:</span>
                            <div class="category-description">{{ Str::limit($category->description, 60) }}</div>
                        </div>
                    @endif
                    <div class="category-card-actions">
                        <a class="btn btn-secondary category-btn-gap-xs" href="{{ route('admin.categorias.show', $category) }}">👁️</a>
                        <a class="btn btn-secondary category-btn-gap-xs" href="{{ route('admin.categorias.edit', $category) }}">✏️</a>
                        <form action="{{ route('admin.categorias.destroy', $category) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit" onclick="return confirm('¿Eliminar esta categoría?')">🗑️</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($categories->hasPages())
        <div class="category-mt-30">
            {{ $categories->links() }}
        </div>
    @endif
@endif

<script>
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.category-card').forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>

@endsection
