@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <span>Busqueda</span>
    </div>

    <div class="search-header">
        <h1 class="search-title">
            Resultados para "{{ $query }}"
        </h1>
        <p class="search-subtitle">{{ $products->total() }} productos encontrados</p>
    </div>

    <turbo-frame id="search-results" class="search-results-frame">
        <div class="search-frame-skeleton" aria-hidden="true">
            @for($i = 0; $i < 6; $i++)
                <div class="search-skeleton-card">
                    <div class="search-skeleton-media"></div>
                    <div class="search-skeleton-line"></div>
                    <div class="search-skeleton-line search-skeleton-line--short"></div>
                    <div class="search-skeleton-line search-skeleton-line--price"></div>
                </div>
            @endfor
        </div>

        <div class="search-frame-content">
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
                                        data-turbo-frame="search-results"
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
                                        data-turbo-frame="search-results"
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
                                        data-turbo-frame="search-results"
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
                    <div class="card-body text-center search-empty-body">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="empty-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="search-empty-title">No se encontraron resultados</h3>
                        <p class="search-empty-text">No encontramos productos que coincidan con "{{ $query }}"</p>
                        <div class="search-empty-actions">
                            <a href="{{ route('shop.catalog') }}" class="btn btn-primary">Ver catalogo</a>
                            <a href="{{ route('shop.home') }}" class="btn btn-secondary">Ir al inicio</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </turbo-frame>
@endsection
