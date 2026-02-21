<turbo-frame id="{{ $turboFrame ?? 'main-content' }}">
    <div class="product-detail mb-4">
        <a
            href="{{ route('content.catalog') }}"
            data-turbo-frame="{{ $turboFrame ?? 'main-content' }}"
            class="btn btn-outline-secondary btn-sm mb-3"
        >
            Volver al catalogo
        </a>

        <div class="card">
            <div class="card-body">
                <div class="product-layout">
                    <div>
                        <div class="product-image-wrap">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                            @else
                                <div class="product-placeholder">Sin imagen</div>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($product->category)
                            <span class="badge badge-primary product-badge">{{ $product->category->name }}</span>
                        @endif

                        <h1 class="product-title">{{ $product->name }}</h1>
                        <p class="product-price">$ {{ number_format($product->price, 2) }}</p>

                        @if($product->description)
                            <p>{{ $product->description }}</p>
                        @endif

                        <p><strong>Stock disponible:</strong> {{ number_format($product->stock_quantity, 0) }}</p>

                        @if($product->stock_quantity > 0)
                            <form action="{{ route('content.cart.add') }}" method="POST" class="product-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="mb-3">
                                    <label for="quantity">Cantidad</label>
                                    <input
                                        id="quantity"
                                        type="number"
                                        name="quantity"
                                        value="1"
                                        min="1"
                                        max="{{ $product->stock_quantity }}"
                                        class="form-control"
                                        style="max-width: 120px;"
                                    >
                                </div>
                                <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
        <section class="related-section">
            <h2 class="related-title">Relacionados</h2>
            <div class="product-grid">
                @foreach($relatedProducts as $relatedProduct)
                    @include('shop._product-card', ['product' => $relatedProduct])
                @endforeach
            </div>
        </section>
    @endif
</turbo-frame>
