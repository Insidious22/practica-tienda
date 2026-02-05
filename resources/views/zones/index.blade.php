@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">📍 Gestión de Zonas</h1>
    <div class="header-actions">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Buscar zonas..." style="padding-left: 36px;">
        </div>
        <a class="btn primary" href="{{ route('admin.zonas.create') }}">➕ Nueva Zona</a>
    </div>
</div>

@if ($zones->count() === 0)
    <div class="empty-state">
        <div class="empty-state-icon">📍</div>
        <div class="empty-state-text">No hay zonas registradas</div>
        <a class="btn primary" href="{{ route('admin.zonas.create') }}">Crear primera zona</a>
    </div>
@else
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        @foreach ($zones as $zone)
            <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: all 0.3s ease;" onmouseenter="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.12)'" onmouseleave="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)'">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 16px; color: white;">
                    <h3 style="margin: 0; font-size: 20px;">{{ $zone->name }}</h3>
                    <span class="muted" style="color: rgba(255,255,255,0.8); font-size: 12px;">Código: <strong>{{ $zone->code }}</strong></span>
                </div>
                <div style="padding: 16px;">
                    @if($zone->description)
                        <div style="margin-bottom: 12px;">
                            <span class="muted">Descripción:</span>
                            <div style="color: #6b7280; margin-top: 4px; font-size: 13px;">{{ Str::limit($zone->description, 70) }}</div>
                        </div>
                    @endif
                    <div style="padding-top: 12px; border-top: 1px solid #e5e7eb;">
                        <div class="muted" style="font-size: 12px; margin-bottom: 12px;">
                            📦 {{ $zone->categories->count() }} categorías
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <a class="btn secondary" href="{{ route('admin.zonas.show', $zone) }}" style="flex: 1; text-align: center; gap: 4px;">👁️</a>
                            <a class="btn secondary" href="{{ route('admin.zonas.edit', $zone) }}" style="flex: 1; text-align: center; gap: 4px;">✏️</a>
                            <form action="{{ route('admin.zonas.destroy', $zone) }}" method="POST" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger" type="submit" style="width: 100%;" onclick="return confirm('¿Eliminar esta zona?')">🗑️</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($zones->hasPages())
        <div style="margin-top: 30px;">
            {{ $zones->links() }}
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
