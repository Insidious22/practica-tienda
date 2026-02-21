<turbo-frame id="{{ $turboFrame ?? 'main-content' }}">
    <div class="catalog-layout">
        <aside>
            <div class="card">
                <div class="card-header">Filtros</div>
                <div class="card-body">
                    <form id="filter-form" action="{{ route('content.catalog') }}" method="GET">
                        <div class="form-group mb-3">
                            <label class="form-label">Buscar</label>
                            <input
                                type="text"
                                class="form-input form-control"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Buscar producto..."
                            >
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Categoria</label>
                            <select name="category" class="form-input form-select">
                                <option value="">Todas las categorias</option>
                                @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                                    <option value="{{ $cat->id }}" @selected((string) request('category') === (string) $cat->id)>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Precio maximo</label>
                            <input
                                type="number"
                                name="max_price"
                                class="form-input form-control"
                                value="{{ request('max_price') }}"
                                min="0"
                                step="0.01"
                            >
                        </div>

                        <button type="submit" class="btn btn-primary catalog-filter-btn">Aplicar filtros</button>
                        <a href="{{ route('content.catalog') }}" class="btn btn-secondary catalog-clear-btn">Limpiar</a>
                    </form>
                </div>
            </div>
        </aside>

        <div>
            <div class="catalog-header">
                <h1 class="catalog-title">Catalogo</h1>
                <span class="catalog-count">{{ $products->total() }} productos encontrados</span>
            </div>

            @if($products->count() > 0)
                <div class="product-grid">
                    @foreach($products as $product)
                        <div class="product-card">
                            <div class="product-image">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <span class="product-image-placeholder">Sin imagen</span>
                                @endif
                            </div>
                            <div class="product-info">
                                @if($product->category)
                                    <div class="product-category">{{ $product->category->name }}</div>
                                @endif
                                <h3 class="product-name">
                                    <a
                                        href="{{ route('content.product', $product) }}"
                                        data-turbo-frame="{{ $turboFrame ?? 'main-content' }}"
                                        data-turbo-prefetch
                                    >
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="card-text text-muted small">
                                    {{ \Illuminate\Support\Str::limit($product->description, 60) }}
                                </p>
                                <div class="product-price">${{ number_format($product->price, 2, ',', '.') }}</div>
                            </div>
                            <div class="product-actions">
                                <form action="{{ route('content.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="add-to-cart-btn">Agregar al carrito</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center catalog-empty-body">
                        <p class="catalog-empty-text">No se encontraron productos.</p>
                    </div>
                </div>
            @endif

            @if($products->hasPages())
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                            @if($products->onFirstPage())
                                <span class="page-link">Anterior</span>
                            @else
                                <a class="page-link" href="{{ $products->previousPageUrl() }}" data-turbo-frame="{{ $turboFrame ?? 'main-content' }}">
                                    Anterior
                                </a>
                            @endif
                        </li>

                        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            <li class="page-item {{ $page === $products->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}" data-turbo-frame="{{ $turboFrame ?? 'main-content' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach

                        <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                            @if($products->hasMorePages())
                                <a class="page-link" href="{{ $products->nextPageUrl() }}" data-turbo-frame="{{ $turboFrame ?? 'main-content' }}">
                                    Siguiente
                                </a>
                            @else
                                <span class="page-link">Siguiente</span>
                            @endif
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</turbo-frame>
