@extends('layouts.shop')

@push('styles')
    @safeVite(['resources/css/shop/category.css'])
@endpush

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

    @if($products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
                @include('shop._product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="pagination">
            {{ $products->links() }}
        </div>
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
@endsection
