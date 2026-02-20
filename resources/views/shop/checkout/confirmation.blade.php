@extends('layouts.shop')

@push('styles')
    @safeVite(['resources/css/shop/checkout.css'])
@endpush

@section('content')
    <div class="confirmation-wrap">
        <!-- Success Header -->
        <div class="confirmation-header">
            <div class="confirmation-icon">
                <svg fill="none" stroke="#10b981" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="confirmation-title">¡Pedido Confirmado!</h1>
            <p class="confirmation-subtitle">Gracias por tu compra. Hemos enviado los detalles a tu correo.</p>
        </div>

        <!-- Order Details -->
        <div class="card confirmation-card">
            <div class="card-body">
                <div class="confirmation-header-row">
                    <div>
                        <p class="confirmation-meta">Numero de pedido</p>
                        <p class="confirmation-number">{{ $order->order_number }}</p>
                    </div>
                    <div class="confirmation-date">
                        <p class="confirmation-meta">Fecha</p>
                        <p class="confirmation-value">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="confirmation-grid">
                    <div>
                        <p class="confirmation-meta">Estado</p>
                        <span class="badge badge-success">{{ $order->status_label }}</span>
                    </div>
                    <div>
                        <p class="confirmation-meta">Metodo de pago</p>
                        <p class="confirmation-value">Tarjeta Online</p>
                    </div>
                </div>

                <div class="confirmation-address">
                    <p class="confirmation-meta">Dirección de envío</p>
                    <p class="confirmation-address-main">{{ $order->shipping_address }}</p>
                    <p class="confirmation-address-secondary">{{ $order->shipping_city }} {{ $order->shipping_postal_code }}</p>
                    @if($order->shipping_notes)
                        <p class="confirmation-note">
                            <strong>Notas:</strong> {{ $order->shipping_notes }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card confirmation-items">
            <div class="card-header">Productos</div>
            <div class="card-body confirmation-items-body">
                <table class="table table-striped align-middle confirmation-table">
                    @foreach($order->items as $item)
                        <tr class="confirmation-row">
                            <td class="confirmation-cell">
                                <div class="confirmation-item">
                                    <div class="confirmation-thumb"></div>
                                    <div>
                                        <p class="confirmation-item-name">{{ $item->product_name }}</p>
                                        <p class="confirmation-item-qty">x{{ (int)$item->quantity }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="confirmation-cell confirmation-price">
                                ${{ number_format($item->total, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <!-- Order Totals -->
        <div class="card confirmation-totals">
            <div class="card-body">
                <div class="confirmation-total-row">
                    <span class="confirmation-total-label">Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2, ',', '.') }}</span>
                </div>
                <div class="confirmation-total-row">
                    <span class="confirmation-total-label">IVA ({{ $order->tax_rate }}%)</span>
                    <span>${{ number_format($order->tax_total, 2, ',', '.') }}</span>
                </div>
                <div class="confirmation-total-row">
                    <span class="confirmation-total-label">Envio</span>
                    <span class="confirmation-total-free">Gratis</span>
                </div>
                <hr class="confirmation-total-divider">
                <div class="confirmation-total-final">
                    <span>Total pagado</span>
                    <span class="confirmation-total-value">${{ number_format($order->total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="confirmation-actions">
            <a href="{{ route('shop.account.orders') }}" class="btn btn-primary">
                Ver mis pedidos
            </a>
            <a href="{{ route('shop.home') }}" class="btn btn-secondary">
                Seguir comprando
            </a>
        </div>
    </div>
@endsection
