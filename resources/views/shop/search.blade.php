@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <span>Busqueda</span>
    </div>

    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 24px; font-weight: 700; margin-bottom: 5px;">
            Resultados para "{{ $query }}"
        </h1>
        <p style="color: #6b7280;">{{ $products->total() }} productos encontrados</p>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">No se encontraron resultados</h3>
                <p style="color: #6b7280; margin-bottom: 20px;">No encontramos productos que coincidan con "{{ $query }}"</p>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <a href="{{ route('shop.catalog') }}" class="btn btn-primary">Ver catalogo</a>
                    <a href="{{ route('shop.home') }}" class="btn btn-secondary">Ir al inicio</a>
                </div>
            </div>
        </div>
    @endif
@endsection
