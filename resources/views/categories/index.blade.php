@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">🏷️ Gestión de Categorías</h1>
    <div class="header-actions">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Buscar categorías..." style="padding-left: 36px;">
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
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        @foreach ($categories as $category)
            <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: all 0.3s ease;" onmouseenter="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.12)'" onmouseleave="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)'">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 16px; color: white;">
                    <h3 style="margin: 0; font-size: 18px;">{{ $category->name }}</h3>
                    @if($category->code)
                        <span class="muted" style="color: rgba(255,255,255,0.8); font-size: 12px;">Código: {{ $category->code }}</span>
                    @endif
                </div>
                <div style="padding: 16px;">
                    <div style="margin-bottom: 12px;">
                        <span class="muted">📍 Zona:</span>
                        <div style="font-weight: 600; color: #1f2937; margin-top: 4px;">{{ $category->zone->name ?? 'Sin zona' }}</div>
                    </div>
                    @if($category->description)
                        <div style="margin-bottom: 12px;">
                            <span class="muted">Descripción:</span>
                            <div style="color: #6b7280; margin-top: 4px; font-size: 13px;">{{ Str::limit($category->description, 60) }}</div>
                        </div>
                    @endif
                    <div style="padding-top: 12px; border-top: 1px solid #e5e7eb; display: flex; gap: 8px;">
                        <a class="btn btn-secondary" href="{{ route('admin.categorias.show', $category) }}" style="flex: 1; text-align: center; gap: 4px;">👁️</a>
                        <a class="btn btn-secondary" href="{{ route('admin.categorias.edit', $category) }}" style="flex: 1; text-align: center; gap: 4px;">✏️</a>
                        <form action="{{ route('admin.categorias.destroy', $category) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit" style="width: 100%;" onclick="return confirm('¿Eliminar esta categoría?')">🗑️</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($categories->hasPages())
        <div style="margin-top: 30px;">
            {{ $categories->links() }}
        </div>
    @endif
@endif

<script>
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('[style*="background: white"]').forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>

@endsection
