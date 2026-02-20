@extends('layouts.shop')

@push('styles')
    @safeVite(['resources/css/shop/cart.css'])
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <span>Carrito</span>
    </div>

    <h1 class="cart-title">Carrito de Compras</h1>

    @if($cart->items->count() > 0)
        <div class="cart-layout">
            <!-- Cart Items -->
            <div class="card">
                <div class="card-body cart-card-body">
                    <table class="table table-striped align-middle cart-table">
                        <thead>
                            <tr class="cart-header-row">
                                <th class="cart-header-cell">Producto</th>
                                <th class="cart-header-cell cart-header-cell--center">Precio</th>
                                <th class="cart-header-cell cart-header-cell--center">Cantidad</th>
                                <th class="cart-header-cell cart-header-cell--right">Subtotal</th>
                                <th class="cart-header-cell cart-header-cell--spacer"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                                <tr class="cart-row">
                                    <td class="cart-cell">
                                        <div class="cart-product">
                                            <div class="cart-thumb">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="cart-thumb-image">
                                                @else
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="cart-thumb-icon">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('shop.product', $item->product->id) }}" class="cart-product-link">
                                                    {{ $item->product->name }}
                                                </a>
                                                @if($item->product->category)
                                                    <p class="cart-product-meta">{{ $item->product->category->name }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart-cell cart-cell--center">
                                        $ {{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="cart-cell cart-cell--center">
                                        <form action="{{ route('shop.cart.update', $item) }}" method="POST" class="cart-qty">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="quantity" value="{{ max(0, $item->quantity - 1) }}" class="cart-qty-button">-</button>
                                            <span class="cart-qty-value">{{ (int)$item->quantity }}</span>
                                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="cart-qty-button">+</button>
                                        </form>
                                    </td>
                                    <td class="cart-cell cart-cell--right cart-cell--price">
                                        $ {{ number_format($item->total, 2) }}
                                    </td>
                                    <td class="cart-cell">
                                        <form action="{{ route('shop.cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="cart-remove-button" title="Eliminar">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="cart-remove-icon">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="card cart-summary-card">
                    <div class="card-header">Resumen del Pedido</div>
                    <div class="card-body">
                        <div class="cart-summary-row">
                            <span class="cart-summary-label">Subtotal ({{ $cart->total_items }} productos)</span>
                            <span>$ {{ number_format($cart->subtotal, 2) }}</span>
                        </div>
                        <div class="cart-summary-row">
                            <span class="cart-summary-label">Envio</span>
                            <span class="cart-summary-free">Gratis</span>
                        </div>
                        <hr class="cart-summary-divider">
                        <div class="cart-summary-total">
                            <span>Total</span>
                            <span class="cart-summary-total-value">$ {{ number_format($cart->subtotal, 2) }}</span>
                        </div>

                        @auth
                            <a href="{{ route('shop.checkout.index') }}" class="btn btn-primary cart-checkout-btn">
                                Proceder al Checkout
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="product-cart-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('shop.login') }}?redirect=checkout" class="btn btn-primary cart-checkout-btn">
                                Iniciar sesion para comprar
                            </a>
                            <p class="cart-login-note">
                                ¿No tienes cuenta? <a href="{{ route('shop.register') }}" class="cart-login-link">Registrate</a>
                            </p>
                        @endauth

                        <form action="{{ route('shop.cart.clear') }}" method="POST" class="cart-clear-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary cart-clear-btn" onclick="return confirm('¿Seguro que quieres vaciar el carrito?')">
                                Vaciar carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center cart-empty-body">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="cart-empty-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h2 class="cart-empty-title">Tu carrito esta vacio</h2>
                <p class="cart-empty-text">Agrega productos para comenzar tu compra</p>
                <a href="{{ route('shop.catalog') }}" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="cart-empty-action-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Explorar productos
                </a>
            </div>
        </div>
    @endif
@endsection
