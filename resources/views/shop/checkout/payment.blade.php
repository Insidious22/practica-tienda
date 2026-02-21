@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.cart') }}">Carrito</a>
        <span class="breadcrumb-separator">/</span>
        <span>Pago</span>
    </div>

    <h1 class="checkout-title">Pago</h1>

    <!-- Progress Steps -->
    <div class="checkout-steps">
        <div class="checkout-step">
            <div class="checkout-step-number checkout-step-number--done">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <span class="checkout-step-label checkout-step-label--done">Envio</span>
        </div>
        <div class="checkout-step-divider checkout-step-divider--active"></div>
        <div class="checkout-step">
            <div class="checkout-step-number checkout-step-number--active">2</div>
            <span class="checkout-step-label checkout-step-label--active">Pago</span>
        </div>
        <div class="checkout-step-divider"></div>
        <div class="checkout-step">
            <div class="checkout-step-number checkout-step-number--idle">3</div>
            <span class="checkout-step-label">Confirmacion</span>
        </div>
    </div>

    <div class="checkout-layout">
        <!-- Payment Form -->
        <div>
            <!-- Shipping Summary -->
            <div class="card shipping-summary">
                <div class="card-body shipping-summary-body">
                    <div>
                        <p class="shipping-summary-title">Dirección de envío</p>
                        <p class="shipping-summary-text">
                            {{ $shippingData['shipping_address'] }}, {{ $shippingData['shipping_city'] }} {{ $shippingData['shipping_postal_code'] }}
                        </p>
                    </div>
                    <a href="{{ route('shop.checkout.index') }}" class="shipping-summary-link">Editar</a>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="card">
                <div class="card-header">Metodo de Pago</div>
                <div class="card-body">
                    <form action="{{ route('shop.checkout.process') }}" method="POST" id="payment-form">
                        @csrf

                        <div class="test-banner">
                            <div class="test-banner-head">
                                <svg fill="none" stroke="#10b981" viewBox="0 0 24 24" class="test-banner-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="test-banner-title">Modo de prueba activo</span>
                            </div>
                            <p class="test-banner-text">
                                El sistema de pagos esta en modo de prueba. Tu pedido sera procesado sin cobro real.
                                En produccion, aqui se integrara Stripe para pagos con tarjeta.
                            </p>
                        </div>

                        <!-- Simulated Card Input -->
                        <div class="form-group mb-3">
                            <label class="form-label">Numero de tarjeta</label>
                            <input type="text" class="form-input form-control test-input" value="4242 4242 4242 4242" disabled>
                            <small class="test-helper">Tarjeta de prueba - no se realizara cobro</small>
                        </div>

                        <div class="shipping-grid">
                            <div class="form-group mb-3">
                                <label class="form-label">Fecha de expiracion</label>
                                <input type="text" class="form-input form-control test-input" value="12/28" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">CVC</label>
                                <input type="text" class="form-input form-control test-input" value="123" disabled>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary checkout-submit checkout-submit--lg" id="submit-btn">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Pagar ${{ number_format($totals['total'], 2, ',', '.') }}
                        </button>
                    </form>

                    <p class="secure-note">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="secure-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Pago seguro procesado por Stripe
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div>
            <div class="card checkout-card-sticky">
                <div class="card-header">Resumen del Pedido</div>
                <div class="card-body">
                    <div class="summary-list summary-list--compact">
                        @foreach($cart->items as $item)
                            <div class="summary-item summary-item--compact">
                                <div class="summary-info">
                                    <p class="summary-name">{{ $item->product->name }}</p>
                                    <p class="summary-qty">x{{ (int)$item->quantity }}</p>
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

    <script>
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerHTML = '<span class="checkout-spinner"></span> Procesando...';
        });
    </script>
@endsection
