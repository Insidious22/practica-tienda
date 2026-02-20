@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/products.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">📦 Gestión de Productos</h1>
    <div class="header-actions">
        <div class="search-box">
            <input type="text" id="searchInput" class="product-search-input" placeholder="Buscar productos...">
        </div>
        <a class="btn btn-primary" href="{{ route('admin.productos.create') }}">➕ Nuevo Producto</a>
    </div>
</div>

@if ($products->count() === 0)
    <div class="empty-state">
        <div class="empty-state-icon">📦</div>
        <div class="empty-state-text">No hay productos registrados</div>
        <a class="btn btn-primary" href="{{ route('admin.productos.create') }}">Crear primer producto</a>
    </div>
@else
    <div class="product-table-wrap">
        <table class="table table-striped table-hover align-middle" id="productsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Categoría / Zona</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="product-row">
                        <td><strong>#{{ $product->id }}</strong></td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            @if($product->description)
                                <br><span class="muted">{{ Str::limit($product->description, 40) }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge primary">{{ $product->barcode }}</span>
                            @if($product->sku)
                                <br><span class="muted">SKU: {{ $product->sku }}</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $product->category->name ?? 'Sin categoría' }}</strong>
                            <br>
                            <span class="muted">📍 {{ $product->category->zone->name ?? 'Sin zona' }}</span>
                        </td>
                        <td>
                            @if($product->price)
                                <strong class="product-price">${{ number_format($product->price, 2, ',', '.') }}</strong>
                            @else
                                <span class="muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge @if($product->stock_quantity < 5) danger @elseif($product->stock_quantity < 20) warning @else success @endif">
                                {{ $product->stock_quantity }} {{ $product->unit }}
                            </span>
                        </td>
                        <td>
                            @if($product->status === 'ACT')
                                <span class="badge success">✓ Activo</span>
                            @elseif($product->status === 'INA')
                                <span class="badge warning">⊘ Inactivo</span>
                            @else
                                <span class="badge danger">✗ Descontinuado</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-secondary" href="{{ route('admin.productos.show', $product) }}" title="Ver detalles">👁️</a>
                                <a class="btn btn-secondary" href="{{ route('admin.productos.edit', $product) }}" title="Editar">✏️</a>
                                <form action="{{ route('admin.productos.destroy', $product) }}" method="POST" class="product-inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit" title="Eliminar" onclick="return confirm('¿Eliminar este producto? Esta acción no se puede deshacer.')">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="product-pagination">
            {{ $products->links() }}
        </div>
    @endif
@endif

<script>
    // Search functionality
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.product-row');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>

@endsection

