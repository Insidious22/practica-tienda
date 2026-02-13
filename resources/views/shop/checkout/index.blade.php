@extends('layouts.shop')

@push('styles')
    @vite(['resources/css/shop/checkout.css'])
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.cart') }}">Carrito</a>
        <span class="breadcrumb-separator">/</span>
        <span>Checkout</span>
    </div>

    <h1 class="checkout-title">Checkout</h1>

    <!-- Progress Steps -->
    <div class="checkout-steps">
        <div class="checkout-step">
            <div class="checkout-step-number checkout-step-number--active">1</div>
            <span class="checkout-step-label checkout-step-label--active">Envio</span>
        </div>
        <div class="checkout-step-divider"></div>
        <div class="checkout-step">
            <div class="checkout-step-number checkout-step-number--idle">2</div>
            <span class="checkout-step-label">Pago</span>
        </div>
        <div class="checkout-step-divider"></div>
        <div class="checkout-step">
            <div class="checkout-step-number checkout-step-number--idle">3</div>
            <span class="checkout-step-label">Confirmacion</span>
        </div>
    </div>

    <div class="checkout-layout">
        <!-- Shipping Form -->
        <div class="card">
            <div class="card-header">Dirección de Envío</div>
            <div class="card-body">
                <form action="{{ route('shop.checkout.shipping') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="form-label">Dirección (Calle y número)</label>
                        <input type="text" name="shipping_address" class="form-input form-control"
                               value="{{ old('shipping_address', $user->address) }}"
                               placeholder="Av. 9 de Octubre 123, Dpto 4B" required>
                        @error('shipping_address')
                            <span class="form-error text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="shipping-grid">
                        <div class="form-group mb-3">
                            <label class="form-label">Cantón / Ciudad</label>
                            <input type="text" name="shipping_city" class="form-input form-control"
                                   value="{{ old('shipping_city', $user->city) }}"
                                   placeholder="Guayaquil (Guayas)" required>
                            @error('shipping_city')
                                <span class="form-error text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Código Postal (6 dígitos)</label>
                            <input type="text" name="shipping_postal_code" class="form-input form-control"
                                   value="{{ old('shipping_postal_code', $user->postal_code) }}"
                                   placeholder="090101" required>
                            @error('shipping_postal_code')
                                <span class="form-error text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Referencia de entrega (opcional)</label>
                        <textarea name="shipping_notes" class="form-input form-control" rows="3"
                                  placeholder="Casa blanca, junto a la farmacia...">{{ old('shipping_notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary checkout-submit">
                        Continuar al pago
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div>
            <div class="card checkout-card-sticky">
                <div class="card-header">Resumen del Pedido</div>
                <div class="card-body">
                    <!-- Items -->
                    <div class="summary-list">
                        @foreach($cart->items as $item)
                            <div class="summary-item">
                                <div class="summary-thumb"></div>
                                <div class="summary-info">
                                    <p class="summary-name">{{ $item->product->name }}</p>
                                    <p class="summary-qty">Cant: {{ (int)$item->quantity }} x ${{ number_format($item->unit_price, 2, ',', '.') }}</p>
                                </div>
                                <div class="summary-price">
                                    ${{ number_format($item->total, 2, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span>${{ number_format($totals['subtotal'], 2, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">IVA ({{ $totals['tax_rate'] }}%)</span>
                        <span>${{ number_format($totals['tax_total'], 2, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Envio</span>
                        <span class="summary-free">Gratis</span>
                    </div>
                    <hr class="summary-divider">
                    <div class="summary-total">
                        <span>Total</span>
                        <span class="summary-total-value">${{ number_format($totals['total'], 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
