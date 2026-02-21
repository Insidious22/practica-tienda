<turbo-frame id="admin-content">
    <div class="header">
        <h1 class="title">Gestion de Productos</h1>
        <div class="header-actions">
            <form action="{{ route('admin.products.list') }}" method="GET" class="search-box">
                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    class="product-search-input"
                    value="{{ request('search') }}"
                    placeholder="Buscar productos..."
                >
            </form>
            <a class="btn btn-primary" href="{{ route('admin.products.form') }}" data-turbo-frame="admin-content">Nuevo Producto</a>
        </div>
    </div>

    @if ($products->count() === 0)
        <div class="empty-state">
            <div class="empty-state-text">No hay productos registrados</div>
        </div>
    @else
        <div class="product-table-wrap">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Categoria / Zona</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>#{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->barcode }}</td>
                            <td>
                                {{ $product->category->name ?? 'Sin categoria' }}
                                <br>
                                <small>{{ $product->category->zone->name ?? 'Sin zona' }}</small>
                            </td>
                            <td>${{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>{{ number_format($product->stock_quantity, 0) }} {{ $product->unit }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-secondary" href="{{ route('admin.products.form.edit', $product) }}" data-turbo-frame="admin-content">Editar</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="product-inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('Eliminar producto?')">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <nav class="mt-4">
                <ul class="pagination">
                    <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                        @if($products->onFirstPage())
                            <span class="page-link">Anterior</span>
                        @else
                            <a class="page-link" href="{{ $products->previousPageUrl() }}" data-turbo-frame="admin-content">Anterior</a>
                        @endif
                    </li>
                    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        <li class="page-item {{ $page === $products->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}" data-turbo-frame="admin-content">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                        @if($products->hasMorePages())
                            <a class="page-link" href="{{ $products->nextPageUrl() }}" data-turbo-frame="admin-content">Siguiente</a>
                        @else
                            <span class="page-link">Siguiente</span>
                        @endif
                    </li>
                </ul>
            </nav>
        @endif
    @endif
</turbo-frame>
