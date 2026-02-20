@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/zones.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">📍 Gestión de Zonas</h1>
    <div class="header-actions">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Buscar zonas..." class="zone-search-input">
        </div>
        <a class="btn btn-primary" href="{{ route('admin.zonas.create') }}">➕ Nueva Zona</a>
    </div>
</div>

@if ($zones->count() === 0)
    <div class="empty-state">
        <div class="empty-state-icon">📍</div>
        <div class="empty-state-text">No hay zonas registradas</div>
        <a class="btn btn-primary" href="{{ route('admin.zonas.create') }}">Crear primera zona</a>
    </div>
@else
    <div class="zone-grid">
        @foreach ($zones as $zone)
            <div class="zone-card">
                <div class="zone-card-header">
                    <h3 class="zone-card-title">{{ $zone->name }}</h3>
                    <span class="muted zone-card-code">Código: <strong>{{ $zone->code }}</strong></span>
                </div>
                <div class="zone-card-body">
                    @if($zone->description)
                        <div class="zone-card-desc-wrap">
                            <span class="muted">Descripción:</span>
                            <div class="zone-card-desc">{{ Str::limit($zone->description, 70) }}</div>
                        </div>
                    @endif
                    <div class="zone-card-footer">
                        <div class="muted zone-card-meta">
                            📦 {{ $zone->categories->count() }} categorías
                        </div>
                        <div class="zone-card-actions">
                            <a class="btn btn-secondary zone-card-action" href="{{ route('admin.zonas.show', $zone) }}">👁️</a>
                            <a class="btn btn-secondary zone-card-action" href="{{ route('admin.zonas.edit', $zone) }}">✏️</a>
                            <form action="{{ route('admin.zonas.destroy', $zone) }}" method="POST" class="zone-card-action">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger zone-card-action-button" type="submit" onclick="return confirm('¿Eliminar esta zona?')">🗑️</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($zones->hasPages())
        <div class="zone-pagination">
            {{ $zones->links() }}
        </div>
    @endif
@endif

<script>
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.zone-card').forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>

@endsection
