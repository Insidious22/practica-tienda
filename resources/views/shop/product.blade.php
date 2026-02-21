@extends('layouts.shop')

@section('content')
    <div class="product-detail-page">
        <div class="breadcrumb">
            <a href="{{ route('shop.home') }}">Inicio</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('shop.catalog') }}">Catalogo</a>
            @if($product->category)
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('shop.category', $product->category) }}">{{ $product->category->name }}</a>
            @endif
            <span class="breadcrumb-separator">/</span>
            <span>{{ $product->name }}</span>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="product-layout">
                <!-- Product Image -->
                    <div>
                        <div class="product-image-wrap">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="product-placeholder">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            @endif
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div>
                        @if($product->category)
                            <span class="badge badge-primary product-badge">{{ $product->category->name }}</span>
                        @endif

                        <h1 class="product-title">{{ $product->name }}</h1>

                        @if($product->sku)
                            <p class="product-sku">SKU: {{ $product->sku }}</p>
                        @endif

                        <div class="product-price">
                            $ {{ number_format($product->price, 2) }}
                        </div>

                        @if($product->stock_quantity > 0)
                            <p class="product-stock">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                En stock ({{ number_format($product->stock_quantity, 0) }} disponibles)
                            </p>
                        @else
                            <p class="product-out">Agotado</p>
                        @endif

                        @if($product->description)
                            <div class="product-desc">
                                <h3 class="product-desc-title">Descripcion</h3>
                                <p class="product-desc-text">{{ $product->description }}</p>
                            </div>
                        @endif

                        <!-- Add to Cart Form -->
                        @if($product->stock_quantity > 0)
                            <form action="{{ route('shop.cart.add') }}" method="POST" class="product-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="qty-control">
                                    <button type="button" onclick="decreaseQty()" class="qty-btn">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="qty-input">
                                    <button type="button" onclick="increaseQty()" class="qty-btn">+</button>
                                </div>

                                <button type="submit" class="btn btn-primary product-cart-btn">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-20">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Agregar al carrito
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <section class="related-section">
                <h2 class="related-title">Productos relacionados</h2>
                <div class="product-grid">
                    @foreach($relatedProducts as $relatedProduct)
                        @include('shop._product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <script>
        function decreaseQty() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function increaseQty() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.max);
            if (parseInt(input.value) < max) {
                input.value = parseInt(input.value) + 1;
            }
        }
    </script>

@endsection
