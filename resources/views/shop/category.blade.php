@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.catalog') }}">Catalogo</a>
        <span class="breadcrumb-separator">/</span>
        <span>{{ $category->name }}</span>
    </div>

    <div class="category-header">
        <div>
            <h1 class="category-title">{{ $category->name }}</h1>
            @if($category->description)
                <p class="category-description">{{ $category->description }}</p>
            @endif
        </div>
        <span class="category-count">{{ $products->total() }} productos</span>
    </div>

    <turbo-frame id="category-results" class="category-results-frame">
        <div class="category-frame-skeleton" aria-hidden="true">
            @for($i = 0; $i < 6; $i++)
                <div class="category-skeleton-card">
                    <div class="category-skeleton-media"></div>
                    <div class="category-skeleton-line"></div>
                    <div class="category-skeleton-line category-skeleton-line--short"></div>
                    <div class="category-skeleton-line category-skeleton-line--price"></div>
                </div>
            @endfor
        </div>

        <div class="category-frame-content">
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
                                        data-turbo-frame="category-results"
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
                                        data-turbo-frame="category-results"
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
                                        data-turbo-frame="category-results"
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
                    <div class="card-body text-center category-empty-body">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="empty-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="category-empty-text">No hay productos en esta categoria.</p>
                        <a href="{{ route('shop.catalog') }}" class="btn btn-primary category-empty-btn">Ver catalogo completo</a>
                    </div>
                </div>
            @endif
        </div>
    </turbo-frame>
@endsection
