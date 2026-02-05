@extends('layouts.shop')

@section('content')
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
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                <!-- Product Image -->
                <div>
                    <div style="aspect-ratio: 1; background: #f3f4f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 120px; height: 120px; opacity: 0.2;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div>
                    @if($product->category)
                        <span class="badge badge-primary" style="margin-bottom: 10px;">{{ $product->category->name }}</span>
                    @endif

                    <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 15px;">{{ $product->name }}</h1>

                    @if($product->sku)
                        <p style="color: #6b7280; font-size: 13px; margin-bottom: 15px;">SKU: {{ $product->sku }}</p>
                    @endif

                    <div style="font-size: 32px; font-weight: 700; color: #667eea; margin-bottom: 20px;">
                         $ {{ number_format($product->price, 2) }}
                    </div>

                    @if($product->stock_quantity > 0)
                        <p style="color: #10b981; font-weight: 500; margin-bottom: 20px; display: flex; align-items: center; gap: 6px;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            En stock ({{ number_format($product->stock_quantity, 0) }} disponibles)
                        </p>
                    @else
                        <p style="color: #ef4444; font-weight: 500; margin-bottom: 20px;">Agotado</p>
                    @endif

                    @if($product->description)
                        <div style="margin-bottom: 25px;">
                            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">Descripcion</h3>
                            <p style="color: #4b5563; line-height: 1.6;">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Add to Cart Form -->
                    @if($product->stock_quantity > 0)
                        <form action="{{ route('shop.cart.add') }}" method="POST" style="display: flex; gap: 15px; align-items: center;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div style="display: flex; align-items: center; border: 2px solid #e5e7eb; border-radius: 8px;">
                                <button type="button" onclick="decreaseQty()" style="padding: 10px 15px; border: none; background: none; cursor: pointer; font-size: 18px;">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" style="width: 60px; text-align: center; border: none; font-size: 16px; font-weight: 600;">
                                <button type="button" onclick="increaseQty()" style="padding: 10px 15px; border: none; background: none; cursor: pointer; font-size: 18px;">+</button>
                            </div>

                            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 14px 30px;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
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
        <section style="margin-top: 50px;">
            <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 20px;">Productos relacionados</h2>
            <div class="product-grid">
                @foreach($relatedProducts as $relatedProduct)
                    @include('shop._product-card', ['product' => $relatedProduct])
                @endforeach
            </div>
        </section>
    @endif

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

    <style>
        @media (max-width: 768px) {
            [style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection
