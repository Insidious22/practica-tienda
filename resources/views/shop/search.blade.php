@extends('layouts.shop')

@push('styles')
    @vite(['resources/css/shop/search.css'])
@endpush

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
@endsection
