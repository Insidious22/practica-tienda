@extends('layouts.shop')

@push('styles')
    @vite(['resources/css/shop/home.css'])
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="home-hero">
        <h1 class="home-hero-title">Bienvenido a Rafatones</h1>
        <p class="home-hero-text">Encuentra los mejores productos a los mejores precios</p>
        <a href="{{ route('shop.catalog') }}" class="btn home-hero-btn">
            Ver Catalogo
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-20">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </a>
    </div>

    <!-- Categories -->
    @if($categories->count() > 0)
        <section class="home-categories">
            <h2 class="home-categories-title">Categorias</h2>
            <div class="home-category-grid">
                @foreach($categories as $category)
                    <a href="{{ route('shop.category', $category) }}" class="home-category-card">
                        <div class="home-category-icon">
                            <svg fill="none" stroke="white" viewBox="0 0 24 24" class="icon-24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <h3 class="home-category-title">{{ $category->name }}</h3>
                        <span class="home-category-count">{{ $category->products_count }} productos</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Featured Products -->
    <section>
        <div class="home-featured-header">
            <h2 class="home-featured-title">Productos Destacados</h2>
            <a href="{{ route('shop.catalog') }}" class="home-featured-link">
                Ver todos
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        @if($featuredProducts->count() > 0)
            <div class="product-grid">
                @foreach($featuredProducts as $product)
                    @include('shop._product-card', ['product' => $product])
                @endforeach
            </div>
        @else
            <div class="home-empty">
                <p class="home-empty-text">No hay productos disponibles en este momento.</p>
            </div>
        @endif
    </section>
@endsection
