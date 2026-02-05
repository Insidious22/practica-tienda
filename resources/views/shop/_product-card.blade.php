<div class="product-card">
    <div class="product-image">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        @else
            <span class="product-image-placeholder">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; opacity: 0.3;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </span>
        @endif
    </div>
    <div class="product-info">
        @if($product->category)
            <div class="product-category">{{ $product->category->name }}</div>
        @endif
        <h3 class="product-name">
            <a href="{{ route('shop.product', $product->slug ?? $product->id) }}">{{ $product->name }}</a>
        </h3>
        <div class="product-price">
            ${{ number_format($product->price, 2, ',', '.') }}
        </div>
    </div>
    <div class="product-actions">
        <form action="{{ route('shop.cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="add-to-cart-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Agregar al carrito
            </button>
        </form>
    </div>
</div>
