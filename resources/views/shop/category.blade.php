@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.catalog') }}">Catalogo</a>
        <span class="breadcrumb-separator">/</span>
        <span>{{ $category->name }}</span>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 5px;">{{ $category->name }}</h1>
            @if($category->description)
                <p style="color: #6b7280;">{{ $category->description }}</p>
            @endif
        </div>
        <span style="color: #6b7280;">{{ $products->total() }} productos</span>
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
            <div class="card-body text-center" style="padding: 60px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; opacity: 0.3; margin: 0 auto 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <p style="color: #6b7280; font-size: 16px;">No hay productos en esta categoria.</p>
                <a href="{{ route('shop.catalog') }}" class="btn btn-primary" style="margin-top: 20px;">Ver catalogo completo</a>
            </div>
        </div>
    @endif
@endsection
