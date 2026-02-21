@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.account.index') }}">Mi Cuenta</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.account.orders') }}">Mis Pedidos</a>
        <span class="breadcrumb-separator">/</span>
        <span>{{ $order->order_number }}</span>
    </div>

    <div class="account-order-detail-header">
        <h1 class="account-order-detail-title">Pedido {{ $order->order_number }}</h1>
        <span class="badge account-order-detail-status badge-{{ $order->online_status === 'paid' || $order->online_status === 'delivered' ? 'success' : ($order->online_status === 'cancelled' ? 'danger' : 'warning') }}">
            {{ $order->status_label }}
        </span>
    </div>

    <div class="account-order-detail-layout">
        <!-- Order Details -->
        <div>
            <!-- Items -->
            <div class="card account-order-items-card">
                <div class="card-header">Productos</div>
                <div class="card-body account-order-items-body">
                    @foreach($order->items as $item)
                        <div class="account-order-item-row">
                            <div class="account-order-item-thumb"></div>
                            <div class="account-order-item-info">
                                <p class="account-order-item-name">{{ $item->product_name }}</p>
                                <p class="account-order-item-meta">Cantidad: {{ (int)$item->quantity }} x $ {{ number_format($item->unit_price, 2) }}</p>
                            </div>
                            <div class="account-order-item-price">
                                $ {{ number_format($item->total, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card">
                <div class="card-header">Direccion de Envio</div>
                <div class="card-body">
                    <p class="account-order-shipping-address">{{ $order->shipping_address }}</p>
                    <p class="account-order-shipping-city">{{ $order->shipping_city }} {{ $order->shipping_postal_code }}</p>
                    @if($order->shipping_notes)
                        <p class="account-order-shipping-note">
                            <strong>Notas:</strong> {{ $order->shipping_notes }}
                        </p>
                    @endif

                    @if($order->tracking_number)
                        <div class="account-order-tracking">
                            <p class="account-order-tracking-label">Numero de seguimiento:</p>
                            <p class="account-order-tracking-value">{{ $order->tracking_number }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div>
            <div class="card account-summary-card">
                <div class="card-header">Resumen</div>
                <div class="card-body">
                    <div class="account-summary-meta">
                        <div class="account-summary-row account-summary-row--small">
                            <span class="account-summary-label">Fecha del pedido</span>
                            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="account-summary-row account-summary-row--small">
                            <span class="account-summary-label">Metodo de pago</span>
                            <span>Tarjeta Online</span>
                        </div>
                    </div>

                    <div class="account-summary-row">
                        <span class="account-summary-label">Subtotal</span>
                        <span>$ {{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="account-summary-row">
                        <span class="account-summary-label">IVA ({{ $order->tax_rate }}%)</span>
                        <span>$ {{ number_format($order->tax_total, 2) }}</span>
                    </div>
                    <div class="account-summary-row">
                        <span class="account-summary-label">Envio</span>
                        <span class="account-summary-free">Gratis</span>
                    </div>
                    <hr class="account-summary-divider">
                    <div class="account-summary-total">
                        <span>Total</span>
                        <span class="account-summary-total-value">$ {{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('shop.account.orders') }}" class="btn btn-secondary account-back-button">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="account-back-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a mis pedidos
            </a>
        </div>
    </div>
@endsection
