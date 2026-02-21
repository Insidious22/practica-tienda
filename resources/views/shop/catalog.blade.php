@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <span>Catalogo</span>
    </div>

    <div class="catalog-layout">
        <!-- Sidebar Filters -->
        <aside>
            <div class="card">
                <div class="card-header">Filtros</div>
                <div class="card-body">
                    <form id="filter-form" action="{{ route('shop.catalog') }}" method="GET" data-turbo-frame="catalog-results" data-turbo-action="advance">
                        <!-- Categories -->
                        <div class="form-group mb-3">
                            <label class="form-label">Categoria</label>
                            <select name="category" class="form-input form-select">
                                <option value="">Todas las categorias</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="form-group mb-3">
                            <label class="form-label">Precio minimo</label>
                            <input type="number" name="min_price" class="form-input form-control" value="{{ request('min_price') }}" placeholder="0" step="0.01">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Precio maximo</label>
                            <input type="number" name="max_price" class="form-input form-control" value="{{ request('max_price') }}" placeholder="1000" step="0.01">
                        </div>

                        <!-- Sort -->
                        <div class="form-group mb-3">
                            <label class="form-label">Ordenar por</label>
                            <select name="sort" class="form-input form-select">
                                <option value="newest" @selected(request('sort') == 'newest')>Mas recientes</option>
                                <option value="price_asc" @selected(request('sort') == 'price_asc')>Precio: menor a mayor</option>
                                <option value="price_desc" @selected(request('sort') == 'price_desc')>Precio: mayor a menor</option>
                                <option value="name" @selected(request('sort') == 'name')>Nombre A-Z</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary catalog-filter-btn">Aplicar filtros</button>

                        @if(request()->hasAny(['category', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('shop.catalog') }}" class="btn btn-secondary catalog-clear-btn" data-turbo-frame="catalog-results" data-turbo-action="advance">Limpiar filtros</a>
                        @endif
                    </form>
                </div>
            </div>
        </aside>

        <!-- Products -->
        <div>
            <turbo-frame id="catalog-results" class="catalog-results-frame">
                <div class="catalog-frame-skeleton" aria-hidden="true">
                    @for($i = 0; $i < 6; $i++)
                        <div class="catalog-skeleton-card">
                            <div class="catalog-skeleton-media"></div>
                            <div class="catalog-skeleton-line"></div>
                            <div class="catalog-skeleton-line catalog-skeleton-line--short"></div>
                            <div class="catalog-skeleton-line catalog-skeleton-line--price"></div>
                        </div>
                    @endfor
                </div>

                <div class="catalog-frame-content">
                    <div class="catalog-header">
                        <h1 class="catalog-title">Catalogo</h1>
                        <span class="catalog-count">{{ $products->total() }} productos encontrados</span>
                    </div>

                    @if($products->count() > 0)
                        <div class="product-grid">
                            @foreach($products as $product)
                                @include('shop._product-card', ['product' => $product])
                            @endforeach
                        </div>

                        @if($products->hasPages())
                            <nav class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                        @if($products->onFirstPage())
                                            <span class="page-link">Anterior</span>
                                        @else
                                            <a
                                                class="page-link"
                                                href="{{ $products->previousPageUrl() }}"
                                                data-turbo-frame="catalog-results"
                                                data-turbo-action="advance"
                                            >
                                                Anterior
                                            </a>
                                        @endif
                                    </li>

                                    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page === $products->currentPage() ? 'active' : '' }}">
                                            <a
                                                class="page-link"
                                                href="{{ $url }}"
                                                data-turbo-frame="catalog-results"
                                                data-turbo-action="advance"
                                            >
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endforeach

                                    <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                                        @if($products->hasMorePages())
                                            <a
                                                class="page-link"
                                                href="{{ $products->nextPageUrl() }}"
                                                data-turbo-frame="catalog-results"
                                                data-turbo-action="advance"
                                            >
                                                Siguiente
                                            </a>
                                        @else
                                            <span class="page-link">Siguiente</span>
                                        @endif
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    @else
                        <div class="card">
                            <div class="card-body text-center catalog-empty-body">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="empty-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <p class="catalog-empty-text">No se encontraron productos con los filtros seleccionados.</p>
                                <a href="{{ route('shop.catalog') }}" class="btn btn-primary catalog-empty-btn">Ver todos los productos</a>
                            </div>
                        </div>
                    @endif
                </div>
            </turbo-frame>
        </div>
    </div>
@endsection
